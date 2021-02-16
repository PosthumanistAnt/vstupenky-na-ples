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
        var seatWidth = 20

        var tables =  [];
        var tableWidth = 50;

        @foreach ($tables as $table)
            @foreach ($table->seats as $seat)
                seats.push(
                    new fabric.Rect({
                        left: {{ $table->position_x }} - seatWidth,
                        top: {{ $table->position_y }} - seatWidth,
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
                    
        tables.forEach(function(table) {
            canvas.add(table);  
            table.seats.forEach(function(seat, seatIndex) {
                canvas.add(seat);  
            });
        });
        for (let i = 0; i < 2; i++) {
            for (let j = 0; j < 2; j++) {
            
            }
        }

        function evaluateX(index) {
            if (index < 4) {
                return (index % 2) + 1;
            } else {
                return (index % 4 > 1) * 3 
            }
        }

        function evaluateY(index) {
            if (index < 4) {
                return (index % 4 > 1) * 3 
            } else {
                return (index % 2) + 1;
            }
        }
    </script>
</div>
