<div class="h-screen pb-4 w-auto">    
    <div class="w-full xl:flex xl:justify-between text-center">
        <button class="btn btn-secondary" wire:click="logout"> Odhlásit </button>
        @admin
            <button class="btn btn-secondary" wire:click="admin"> Admin </button>
        @endadmin
    </div>
    <div class="xl:flex my-12 h-full">
        <div id="canvas-wrapper" class="w-full xl:w-2/3 h-2/3 xl:h-full pl-4">
            <canvas id="canvas"></canvas>
        </div>
        <div class="w-full xl:w-1/3">
            <h2 class="text-3xl text-center tracking-wide"> Nákupní košík </h2>
        </div>
    </div>
    
    <script>    
        class Table {
            constructor(seats, coordinates) {
                this.seats = seats;
                this.coordinates = coordinates;
            }
        }

        // resize the canvas  
        var canvas = new fabric.Canvas('canvas', {
            backgroundColor: 'brown',
            width: document.getElementById('canvas-wrapper').clientWidth,
            height: document.getElementById('canvas-wrapper').clientHeight,
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

        //set js objects from results from DB
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
                evaluatedPosition = evaluateSeatPosition(seatIndex, table);
                seat.left = evaluatedPosition.x;
                seat.top = evaluatedPosition.y;
                // console.log(seat.top);
                canvas.add(seat); 
            });
        });


        function evaluateSeatPosition(seatIndex, table) {
            var position = this.positionsList[seatIndex];
            var tableCoords = table.aCoords;
            console.log(typeof(tableCoords[position.corner].x));
            console.log(tableCoords[position.corner].x);
            var x = tableCoords[position.corner].x + position.x * seatWidth;
            var y = tableCoords[position.corner].y + position.y * seatWidth;
            return {
                x: x,
                y: y
            };
        }
    </script>
</div>
