<div class="h-screen pb-4 w-auto">    
    <div class="w-full xl:flex xl:justify-between text-center">
        <button class="btn btn-secondary" wire:click="logout"> Odhlásit </button>
        @admin
            <button class="btn btn-secondary" wire:click="admin"> Admin </button>
        @endadmin
    </div>
    <div class="xl:flex my-12 h-full">
        <div id="canvas-wrapper" class="w-full xl:w-2/3 h-full xl:h-2/3 pl-4">
            <canvas id="canvas"></canvas>
        </div>
        <div class="w-full xl:w-1/3">
            <h2 class="text-3xl text-center tracking-wide"> Nákupní košík (TODO) </h2>
        </div>
    </div>

    <script>   
        // resize the canvas  
        var canvas = new fabric.Canvas('canvas', {
            backgroundColor: 'brown',
            width: document.getElementById('canvas-wrapper').clientWidth,
            height: document.getElementById('canvas-wrapper').clientHeight,
        });

        //panning and zooming
        canvas.on('mouse:down', function(opt) {
            var evt = opt.e;
            if (evt.altKey === true) {
                this.isDragging = true;
                this.selection = false;
                this.lastPosX = evt.clientX;
                this.lastPosY = evt.clientY;
            }
        });

        canvas.on('mouse:move', function(opt) {
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

        canvas.on('mouse:up', function(opt) {
            // on mouse up we want to recalculate new interaction
            // for all objects, so we call setViewportTransform
            this.setViewportTransform(this.viewportTransform);
            this.isDragging = false;
            this.selection = true;
        });

        canvas.on('mouse:down', function(opt) {
            if(opt.target && opt.target.seatId !== undefined){
                var seatId = opt.target.seatId;
                Livewire.emit('addToCart', seatId);
            }
        });

        canvas.on('mouse:wheel', function(opt) {
        var delta = opt.e.deltaY;
        var zoom = canvas.getZoom();
        zoom *= 0.98 ** delta;
        if (zoom > 5) zoom = 5;
        if (zoom < 0.2) zoom = 0.2;
        canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
        opt.e.preventDefault();
        opt.e.stopPropagation();
        });
        var seats =  [];
        var seatWidth = 20;

        var tables =  [];
        var tableWidth = 50;
        
        //change in position of seat depending on its index in table
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

        //push results from DB to js arrays
        @foreach ($tables as $table)
            @foreach ($table->seats as $seat)
                seats.push(
                    new fabric.Rect({
                        left: {{ $table->position_x }},
                        top: {{ $table->position_y }},
                        width: seatWidth,
                        height: seatWidth,
                        fill: "blue",
                        seatId: {{ $seat->id }},
                        seatType: {{ $seat->seatType->id }},
                    })
                );   
            @endforeach
            tables.push(
                new fabric.Rect({
                    left: {{ $table->position_x }},
                    top: {{ $table->position_y }},
                    width: tableWidth,
                    height: tableWidth,
                    fill: "black",
                    seats: seats,
                })
            );
            seats = [];
        @endforeach
                    
        //add everything to canvas
        tables.forEach(function(table) {
            canvas.add(table);  
            var seatsLength = table.seats.length;

            table.seats.forEach(function(seat, seatIndex) {
                evaluatedPosition = evaluateSeatPosition(seatIndex, table, positionsList);
                seat.left = evaluatedPosition.x;
                seat.top = evaluatedPosition.y;
                canvas.add(seat); 
            });
        });


        function evaluateSeatPosition(seatIndex, table, positionsList) {
            var position = positionsList[seatIndex];
            var tableCoords = table.aCoords;

            var x = tableCoords[position.corner].x + position.x * seatWidth;
            var y = tableCoords[position.corner].y + position.y * seatWidth;

            return {
                x: x,
                y: y
            };
        }
    </script>
</div>
