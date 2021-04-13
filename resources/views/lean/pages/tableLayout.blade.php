<div class="h-screen w-auto">    
    <div class="h-1/3 w-auto m-4 flex justify-between p-5" x-data>
        <button class="p-5 bg-brand-600 text-white" @click="Lean.modal('create', {'resource': 'tables'})">Přidat stůl</button>
        <button class="p-5 bg-brand-600 text-white" @click="Lean.modal('create', {'resource': 'seats'})">Přidat vstupenku</button>
        <div class="p-5 bg-brand-600 text-white">
            <input type="checkbox" id="show_modals" name="show_modals" checked>
            <label for="show_modals"> Zobrazit modaly při kliknutí </label><br>
        </div>
    </div>

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="my-12 h-full">
        <div id="canvas-wrapper" class="w-full h-screen" wire:ignore>
            <canvas id="canvas"></canvas>
        </div>
    </div>

    <script>   
        var seatWidth = 20;

        var tables =  [];
        var tableWidth = 50;

        var panning = false;

        // change in position of seat depending on its index in table
        var positionsList = [
            {
                corner: 'tl',
                x: 0,
                y: -1
            },
            {
                corner: 'tr',
                x: -1,
                y: -1
            },
            {
                corner: 'bl',
                x: 0,
                y: 0
            },
            {
                corner: 'br',
                x: -1,
                y: 0
            },
            {
                corner: 'tl',
                x: -1,
                y: 0
            },
            {
                corner: 'bl',
                x: -1,
                y: -1
            },
            {
                corner: 'tr',
                x: 0,
                y: 0
            },
            {
                corner: 'br',
                x: 0,
                y: -1
            }
        ];

        // resize and initialize the canvas  
        var canvas = new fabric.Canvas('canvas', {
            backgroundColor: 'brown',
            width: document.getElementById('canvas-wrapper').clientWidth,
            height: document.getElementById('canvas-wrapper').clientHeight,
        });

        // add guiding lines to know where coordinates start
        // add vertical guiding line
        canvas.add(new fabric.Line([0, 0, 0, 4000], {
            left: 0,
            top: -2000,
            stroke: 'black',
            selectable: false,        
        }));

        // add horizontal guiding line
        canvas.add(new fabric.Line([0, 0, 4000, 0], {
            left: -2000,
            top: 0,
            stroke: 'black',
            selectable: false,
        }));

        canvas.on('mouse:down', function (e) {
            panning = true;
        });

        canvas.on('mouse:up', function (e) {
            panning = false;
            this.selection = true;
        });

        canvas.on('mouse:move', function (e) {
            if (panning && e && e.e && e.e.altKey === true) {
                var units = 10;
                var delta = new fabric.Point(e.e.movementX, e.e.movementY);
                this.selection = false;
                canvas.relativePan(delta);
            }
        });
        
        // zooming
        canvas.on( 'mouse:wheel', function(opt) {
            var delta = opt.e.deltaY;
            var zoom = canvas.getZoom();
            zoom *= 0.98 ** delta;
            if (zoom > 5) zoom = 5;
            if (zoom < 0.2) zoom = 0.2;
            canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
            opt.e.preventDefault();
            opt.e.stopPropagation();
        });
        
        // clicking on a seat and adding it to cart
        canvas.on( 'mouse:down', function( e ) {
            if( document.getElementById("show_modals").checked ) {
                if( e.target?.type === "seatGroup") {
                    Lean.modal( 'edit', {
                        'resource': 'seats',
                        'model': e.target.seatId
                    });
                }

                if( e.target?.type === "table") {
                    Lean.modal( 'edit', {
                        'resource': 'tables',
                        'model': e.target.tableId
                    });
                }
            }
        });

        // moving seats when table is moving
        canvas.on( 'object:moving', function(e) {
            handleTableMove( e );
        });

        // moved seats - same as on moving but on moved
        canvas.on( 'object:moved', function( e ) {
            handleTableMove( e );
        });

        // push results from DB to js arrays
        @foreach ( $tables as $table )
            var table = new fabric.Rect({
                left: {{ $table->position_x }},
                top: {{ $table->position_y }},
                width: tableWidth,
                height: tableWidth,
                type: 'table',
                hasControls: false,
                tableId: {{ $table->id }},
                fill: "black",
                seatGroups: [],
            });

            tables.push( table );
            canvas.add( table );

            @foreach( $table->seats as $seat )
            
                var groupPosition = evaluateSeatGroupPosition( {{ $loop->index }}, table );

                var seat = new fabric.Rect({
                    originX: 'center',
                    originY: 'center',
                    width: seatWidth,
                    height: seatWidth,
                    @if( $seat->seatType->color )
                        fill: "{{ $seat->seatType->color }}",
                    @else
                        fill: "blue",
                    @endif
                    seatId: {{ $seat->id }},
                    seatType: {{ $seat->seatType->id }},
                    type: 'seat',
                });

                var text = new fabric.Text( "{{ $seat->number }}" , {
                    fill: 'white',
                    fontSize: 10,
                    originX: 'center',
                    originY: 'center',
                    type: 'seatNumber',
                });

                var seatGroup = new fabric.Group([ seat, text ], {
                    left: groupPosition.x,
                    top: groupPosition.y,
                    selectable: false,
                    seatId: {{ $seat->id }},
                    type: 'seatGroup',
                });

                table.seatGroups.push( seatGroup );  
                canvas.add( table.seatGroups[ {{$loop->index }} ] );

            @endforeach
        @endforeach

        function handleTableMove( e ) {
            var selectedObject = e.target;

            if ( selectedObject.type === 'table' ) {
                setCorrectSeatGroupsPosition( selectedObject );
                emitPositionChangeToLivewire( selectedObject, e.e.type );
            }

            if ( selectedObject.type === 'activeSelection' ) {
                selectedObject._objects.forEach( function ( table ) {
                    setCorrectSeatGroupsPosition( table, selectedObject ),
                    emitPositionChangeToLivewire( table, e.e.type, selectedObject)
                });
            }
        }

        function emitPositionChangeToLivewire( table, eventType, group = null) {
            if ( eventType !== "mouseup") {
                return;
            }

            var groupOffset = {
                x: 0,
                y: 0
            };
            
            if( group ){
                groupOffset.x = group.aCoords.tl.x + group.width/2;
                groupOffset.y = group.aCoords.tl.y + group.height/2;
            }
            
            var movedTableAttributes = {
                'id': table.tableId,
                'x': table.left + groupOffset.x,
                'y': table.top + groupOffset.y
            };

            livewire.emit('tablePositionUpdated', movedTableAttributes );
        }

        function setCorrectSeatGroupsPosition( table, group ) {
            table.seatGroups.forEach( function ( seatGroup, seatGroupIndex ) {       
                var evaluatedSeatGroupPosition = evaluateSeatGroupPosition( seatGroupIndex, table, group );
                seatGroup.left = evaluatedSeatGroupPosition.x;
                seatGroup.top = evaluatedSeatGroupPosition.y;
                seatGroup.setCoords();
            });
        }
        
        function evaluateSeatGroupPosition(seatIndex, table, group = null) {

            var groupOffset = {
                x: 0,
                y: 0
            };
            
            if(group){
                groupOffset.x = group.aCoords.tl.x + group.width/2;
                groupOffset.y = group.aCoords.tl.y + group.height/2;
            }

            if( seatIndex > 7 ) {
                alert( 'Stůl ' + seatIndex + ' má přiřazených více než 8 vstupenek.')
                return;
            }

            var desiredPosition = positionsList[seatIndex];

            var tableCoords = table.calcCoords(true);

            var x = tableCoords[desiredPosition.corner].x + desiredPosition.x * seatWidth + groupOffset.x;
            var y = tableCoords[desiredPosition.corner].y + desiredPosition.y * seatWidth + groupOffset.y;

            return {
                x: x,
                y: y
            };
        }
    </script>
</div>
