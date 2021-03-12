<div class="h-screen w-auto">    
    <div class="h-1/3 w-auto m-4 flex justify-between p-5">
        <a href="{{ url('admin/tables/create') }}" class="p-5 bg-purple-600 text-white">Přidat stůl</a>
        <button class="p-5 bg-purple-600 text-white" onclick="duplicateSelection()">Duplikovat výběr</button>
        <button class="p-5 bg-purple-600 text-white">Uložit do databáze</button>
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
        canvas.on( 'mouse:down', function(opt) {
            if( opt.target && opt.target.seatId !== undefined ){
                var seat = opt.target;
                seat.set("fill", 'green');
            } 
        });

        // moving seats when table is moving
        canvas.on( 'object:moving', function(e) {
            var selectedObject = e.target;

            if (selectedObject.type !== 'activeSelection') {
                selectedObject.seats.forEach( function( seat, seatIndex ) {
                    var seatPosition = evaluateSeatPosition( seatIndex, selectedObject )
                    seat.left = seatPosition.x;
                    seat.top = seatPosition.y;
                });
            }
            if (selectedObject.type === 'activeSelection') {
                selectedObject._objects.forEach(table => {
                    console.log(table);
                    table.seats.forEach( function( seat, seatIndex ) {
                        var seatPosition = evaluateSeatPosition( seatIndex, table, selectedObject )
                        seat.left = seatPosition.x;
                        seat.top = seatPosition.y;
                    });
                });
            }
        });

        // moved seats - same as on moving but on moved
        canvas.on( 'object:moved', function(e) {
            var selectedObject = e.target;

            if (selectedObject.type !== 'activeSelection') {
                selectedObject.seats.forEach( function( seat, seatIndex ) {
                    var seatPosition = evaluateSeatPosition( seatIndex, selectedObject )
                    seat.left = seatPosition.x;
                    seat.top = seatPosition.y;
                });
            }
            if (selectedObject.type === 'activeSelection') {
                selectedObject._objects.forEach(table => {
                    console.log(table);
                    table.seats.forEach( function( seat, seatIndex ) {
                        var seatPosition = evaluateSeatPosition( seatIndex, table, selectedObject )
                        seat.left = seatPosition.x;
                        seat.top = seatPosition.y;
                    });
                });
            }
        });

        // push results from DB to js arrays
        @foreach ( $tables as $table )
            var table = new fabric.Rect({
                left: {{ $table->position_x }},
                top: {{ $table->position_y }},
                width: tableWidth,
                height: tableWidth,
                fill: "black",
                seats: [],
            });
            tables.push( table );
            canvas.add( table );

            @foreach( $table->seats as $seat )
                var groupPosition = evaluateSeatPosition( {{ $loop->index }}, table );
                var seat = new fabric.Rect({
                    originX: 'center',
                    originY: 'center',
                    width: seatWidth,
                    height: seatWidth,
                    fill: "blue",
                    seatId: {{ $seat->id }},
                    seatType: {{ $seat->seatType->id }},
                });

                var text = new fabric.Text( "{{ $seat->number }}" , {
                    fill: 'white',
                    fontSize: 12,
                    originX: 'center',
                    originY: 'center'
                });

                var group = new fabric.Group([ seat, text ], {
                    left: groupPosition.x,
                    top: groupPosition.y,
                    selectable: false,
                });

                table.seats.push( group );  

                canvas.add( table.seats[ {{$loop->index }}]);
            @endforeach
        @endforeach

        function evaluateSeatPosition(seatIndex, table, group = null) {
            var groupOffset = {
                x: 0,
                y: 0
            };

            if(group){
                groupOffset.x = group.aCoords.tl.x + group.width/2;
                groupOffset.y = group.aCoords.tl.y + group.height/2;
            }

            var desiredPosition = positionsList[seatIndex];
            var tableCoords = table.aCoords;

            var x = tableCoords[desiredPosition.corner].x + desiredPosition.x * seatWidth + groupOffset.x;
            var y = tableCoords[desiredPosition.corner].y + desiredPosition.y * seatWidth + groupOffset.y;

            return {
                x: x,
                y: y
            };
        }

        // var $ = function(id){return document.getElementById(id)};
        // var rect = new fabric.Rect({
        // width: 100,
        // height: 100,
        // top: 100,
        // left: 100,
        // fill: 'rgba(255,0,0,0.5)'
        // });

        // canvas.add(rect);

        // var angleControl = $('angle-control');
        //     angleControl.oninput = function() {
        //     rect.set('angle', parseInt(this.value, 10)).setCoords();
        //     canvas.requestRenderAll();
        // };

        // function updateControls() {
        //     angleControl.value = rect.angle;
        // }
        // canvas.on({
        //     'object:rotating': updateControls,
        // });

        function duplicateSelection(){
            console.log( canvas.getActiveObject() );
            if (!canvas.getActiveObject()) {
                console.log( 'Neni nic vybraneho' );
                return;
            }
            if (canvas.getActiveObject().type !== 'activeSelection') {
                console.log( 'Jenom 1 objekt' );
                return;
            }
            canvas.add( canvas.getActiveObject().clone() );
            canvas.requestRenderAll();
            // canvas.add( canvas.getActiveObject() );
            // var table = new fabric.Rect({
            //     left: {{ $table->position_x }},
            //     top: {{ $table->position_y }},
            //     width: tableWidth,
            //     height: tableWidth,
            //     fill: "black",
            //     seats: [],
            // });
        }
        
    </script>
</div>
