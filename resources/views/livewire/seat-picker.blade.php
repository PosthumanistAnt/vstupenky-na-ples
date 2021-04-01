<div class="h-screen pb-4 w-auto">    
    <div class="xl:flex my-12 h-full mt-60">
        <div id="canvas-wrapper" class="w-full xl:w-2/3 h-full xl:h-2/3 pl-4" wire:ignore>
            <canvas id="canvas"></canvas>
        </div>
        <div class="w-full xl:w-1/3">
            <h2 class="text-3xl text-center tracking-wide"> Nákupní košík (TODO) </h2>
        </div>
    </div>

    <script>   
        var seats =  [];
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

                canvas.add( table.seats[ table.seats.length - 1 ]);
            @endforeach
        @endforeach


        // move seats when table is moving
        canvas.on('object:moving', function(e) {
            var table = e.target;

            table.seats.forEach( function( seat, seatIndex ) {
                var seatPosition = evaluateSeatPosition(seatIndex, table)
                seat.left = seatPosition.x;
                seat.top = seatPosition.y;
            });
        });

        // same as on moving but on moved
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
    </script>
</div>
