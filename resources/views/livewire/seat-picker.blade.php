<div class="h-full w-screen bg-gray-900 text-gray-200">
    <div class="w-full xl:flex xl:justify-between">
        <x-buttons.secondary-button text='Odhlásit' livewireFunction='logout' />
        @admin
            <x-buttons.secondary-button text='Admin' livewireFunction='admin' />
        @endadmin
    </div>
    
    <div id="c" class="w-screen h-screen">
        <canvas height="1000" width="1000" id="canvas" class="w-screen h-screen"></canvas>
    </div>

    <div class="w-full h-full bg-red-300">

    </div>
    
    <script>        
        var canvas = new fabric.Canvas('canvas');
        var rects =  [];
  
        @foreach ($seats as $seat)
            console.log('dalsi');
            rects.push(
                new fabric.Rect({
                left: 1 * 30,
                top: 1 * 30,
                width: 20,
                height: 20,
                color: "RED",
            }));   
        @endforeach

        for (let index = 0; index < rects.length; index++) {
            canvas.add(rects[index]);   
        }
    </script>
</div>
