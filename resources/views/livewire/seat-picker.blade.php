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

        var tables =  [];
        var seats =  [];
        var tableRadius = 30;
        var tableDistance = 10;

        @foreach ($tables as $table)
            @foreach ($table->seats as $seat)
                seats.push(
                    new fabric.Rect({
                    left: {{ $table->position_x }} - 20,
                    top: {{ $table->position_y }} - 20,
                    width: 20,
                    height: 20,
                    fill: "blue",
                    seatId: {{ $seat->id }},
                    seatType: {{ $seat->seatType->id }},
                }));   
            @endforeach
            tables.push(
                new fabric.Rect({
                    left: {{ $table->position_x }},
                    top: {{ $table->position_y }},
                    width: 40,
                    height: 40,
                    fill: "black",
                    seats: seats,
            }));
            seats = [];
        @endforeach
                    
        tables.forEach(function(table) {
            canvas.add(table);  
            table.seats.forEach(function(seat) {
                canvas.add(seat);  
            });
        });

    </script>
</div>
