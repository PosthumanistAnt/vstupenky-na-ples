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

        // panning
        canvas.on( 'mouse:down', function(opt) {
            var evt = opt.e;
            if (evt.altKey === true) {
                this.isDragging = true;
                this.selection = false;
                this.lastPosX = evt.clientX;
                this.lastPosY = evt.clientY;
            }
        });

        // still panning
        canvas.on( 'mouse:move', function(opt) {
            if (this.isDragging) {
                var e = opt.e;
                var vpt = this.viewportTransform;
                vpt[4] += e.clientX - this.lastPosX;
                vpt[5] += e.clientY - this.lastPosY;
                this.requestRenderAll();
                this.lastPosX = e.clientX;
                this.lastPosY = e.clientY;
            }
        });

        // also panning
        canvas.on( 'mouse:up', function(opt) {
            // on mouse up we want to recalculate new interaction
            // for all objects, so we call setViewportTransform
            this.setViewportTransform(this.viewportTransform);
            this.isDragging = false;
            this.selection = true;
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
            tables.push(table);
            canvas.add(table);

            @foreach( $table->seats as $seat )
                var seatPosition = evaluateSeatPosition({{ $loop->index }}, table);

                table.seats.push( new fabric.Rect({
                    left: seatPosition.x,
                    top: seatPosition.y,
                    width: seatWidth,
                    height: seatWidth,
                    fill: "blue",
                    selectable: false,
                    seatId: {{ $seat->id }},
                    seatType: {{ $seat->seatType->id }},
                }));  

                canvas.add( table.seats[ {{$loop->index }}]);
            @endforeach
        @endforeach

        // moving seats when table is moving
        canvas.on('object:moving', function(e) {
            var table = e.target;

            table.seats.forEach( function( seat, seatIndex ) {
                var seatPosition = evaluateSeatPosition(seatIndex, table)
                seat.left = seatPosition.x;
                seat.top = seatPosition.y;
            });
        });

        // moved seats - same as on moving but on moved
        canvas.on('object:moved', function(e) {
            var table = e.target;

            table.seats.forEach( function( seat, seatIndex ) {
                var seatPosition = evaluateSeatPosition(seatIndex, table)
                seat.left = seatPosition.x;
                seat.top = seatPosition.y;
            });
        });


        function evaluateSeatPosition(seatIndex, table) {
            var desiredPosition = positionsList[seatIndex];
            var tableCoords = table.aCoords;

            var x = tableCoords[desiredPosition.corner].x + desiredPosition.x * seatWidth;
            var y = tableCoords[desiredPosition.corner].y + desiredPosition.y * seatWidth;

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

        function addTable(){
            var num_seats = document.getElementById('num-seats').value;
            console.log(num_seats);
            var table = new fabric.Rect({
                left: {{ $table->position_x }},
                top: {{ $table->position_y }},
                width: tableWidth,
                height: tableWidth,
                fill: "black",
                seats: [],
            });

        }

    </script>
</div>
