<div class="h-full w-screen bg-gray-900 text-gray-300">
    <div class="w-full xl:flex xl:justify-between">
        <x-buttons.secondary-button text='Odhlásit' livewireFunction='logout' />
        @admin
            <x-buttons.secondary-button text='Admin' livewireFunction='admin' />
        @endadmin
    </div>
    
    <div id="c" class="w-screen h-screen">
        <canvas height="1000" width="1000" id="canvas" class="w-screen h-screen"></canvas>
    </div>

    <script>

        var canvas = new fabric.Canvas('canvas');
        var rects =  [];
        for (let i = 10; i < 78; i++) {
            // create a rectangle
            rects.push(
                new fabric.Rect({
                left: i%8 * 30,
                top: parseInt(i/8) * 30,
                fill: '#' + (i-10) + i + (i+20),
                width: 20,
                height: 20,
            }));     
        }

        for (let index = 0; index < rects.length; index++) {
            canvas.add(rects[index]);   
        }
    </script>
</div>
