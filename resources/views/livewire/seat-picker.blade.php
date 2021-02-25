<div class="h-screen pb-4 w-auto">    
    <div class="w-full xl:flex xl:justify-between text-center">
        <button class="btn btn-secondary" wire:click="logout"> Odhlásit </button>
        @admin
            <button class="btn btn-secondary" wire:click="admin"> Admin </button>
        @endadmin
    </div>
    <div class="xl:flex my-12 h-full">
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

        // figuring out how groups work
        canvas.on( 'mouse:down', function(opt) {
            var table = new fabric.Rect ({
                width: 100,
                height: 20,
                fill: '#eef',
                scaleY: 1,
                originX: 'center',
                originY: 'center',
                seats: [],
            })

            table.seats.push( new fabric.Circle ({
                radius: 100,
                fill: '#eef',
                scaleY: 0.5,
                originX: 'center',
                originY: 'center'
            }));

            table.seats.push( new fabric.Circle ({
                radius: 40,
                fill: '#eef',
                scaleY: 2,
                originX: 'left',
                originY: 'top'
            }));

            var group = new fabric.Group( [ table ] , {
                left: 150,
                top: 100,
                angle: -10
            });
            
            group.addWithUpdate( new fabric.Circle ({
                radius: 40,
                fill: '#eef',
                scaleY: 2,
                originX: 'center',
                originY: 'center',
            }));
            
            // var group = new fabric.Group([ circle, text ], {
            //     left: 150,
            //     top: 100,
            //     angle: -10
            // });

            //canvas.add(group);
        });
        
        // push results from DB to js arrays
        @foreach ( $tables as $table )
            // var table = new fabric.Rect({
            //     left: {{ $table->position_x }}+20,
            //     top: {{ $table->position_y }}+20,
            //     width: tableWidth,
            //     height: tableWidth,
            //     fill: "blue",
            // });
            
            // canvas.add(table);

            var table = new fabric.Rect({
                left: {{ $table->position_x }},
                top: {{ $table->position_y }},
                width: tableWidth,
                height: tableWidth,
                fill: "black",
                label: {{ $table->id }},
                seats: [],
            });


            @foreach( $table->seats as $seat )
                table.seats.push( new fabric.Rect({
                    left: table.left+50,
                    // left: evaluateSeatPosition( {{ $loop->index }},  table),
                    top: table.top+50,
                    width: seatWidth,
                    height: seatWidth,
                    fill: "blue",
                    label: {{ $seat->id }},
                    selectable: false,
                    seatId: {{ $seat->id }},
                    seatType: {{ $seat->seatType->id }},
                }));  
                canvas.add( table.seats[ table.seats.length - 1 ]);
            @endforeach


            canvas.add(table);
        @endforeach


                    
        canvas.on('object:moving', function(e) {
            var table = e.target;

            table.seats.forEach( function( seat, seatIndex ) {
                var seatPosition = evaluateSeatPosition(seatIndex, table)
                seat.left = seatPosition.x;
                seat.top = seatPosition.y;
            });

            canvas.on('object:moved', function(e) {
                var table = e.target;

                table.seats.forEach( function( seat, seatIndex ) {
                    var seatPosition = evaluateSeatPosition(seatIndex, table)
                    seat.left = seatPosition.x;
                    seat.top = seatPosition.y;
                });
            });
            
            // if( opt.target && opt.target.seatId !== undefined ){
            // }
            var p = e.target;
            p.line1 && p.line1.set({ 'x2': p.left, 'y2': p.top });
            p.line2 && p.line2.set({ 'x1': p.left, 'y1': p.top });
            p.line3 && p.line3.set({ 'x1': p.left, 'y1': p.top });
            p.line4 && p.line4.set({ 'x1': p.left, 'y1': p.top });
            canvas.renderAll();
        });
        // add everything to canvas
        // tables.forEach(function(table) {

        //     canvas.add(table);  
        //     var seatsLength = table.seats.length;

        //     table.seats.forEach(function(seat, seatIndex) {
        //         evaluatedPosition = evaluateSeatPosition(seatIndex, table);
        //         seat.left = evaluatedPosition.x;
        //         seat.top = evaluatedPosition.y;
        //         canvas.add(seat); 
        //     });
        // });


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


    function makeCircle(left, top, line1, line2, line3, line4) {
        var c = new fabric.Circle({
        left: left,
        top: top,
        strokeWidth: 5,
        radius: 12,
        fill: '#fff',
        stroke: '#666'
        });
        c.hasControls = c.hasBorders = false;

        c.line1 = line1;
        c.line2 = line2;
        c.line3 = line3;
        c.line4 = line4;

        return c;
    }

    function makeLine(coords) {
        return new fabric.Line(coords, {
        fill: 'red',
        stroke: 'red',
        strokeWidth: 5,
        selectable: false,
        evented: false,
        });
    }

    var line = makeLine([ 250, 125, 250, 175 ]),
        line2 = makeLine([ 250, 175, 250, 250 ]),
        line3 = makeLine([ 250, 250, 300, 350]),
        line4 = makeLine([ 250, 250, 200, 350]),
        line5 = makeLine([ 250, 175, 175, 225 ]),
        line6 = makeLine([ 250, 175, 325, 225 ]);

    canvas.add(line, line2, line3, line4, line5, line6);

    canvas.add(
        makeCircle(line.get('x1'), line.get('y1'), null, line),
        makeCircle(line.get('x2'), line.get('y2'), line, line2, line5, line6),
        makeCircle(line2.get('x2'), line2.get('y2'), line2, line3, line4),
        makeCircle(line3.get('x2'), line3.get('y2'), line3),
        makeCircle(line4.get('x2'), line4.get('y2'), line4),
        makeCircle(line5.get('x2'), line5.get('y2'), line5),
        makeCircle(line6.get('x2'), line6.get('y2'), line6)
    );

    canvas.on('object:moving', function(e) {
        var p = e.target;
        p.line1 && p.line1.set({ 'x2': p.left, 'y2': p.top });
        p.line2 && p.line2.set({ 'x1': p.left, 'y1': p.top });
        p.line3 && p.line3.set({ 'x1': p.left, 'y1': p.top });
        p.line4 && p.line4.set({ 'x1': p.left, 'y1': p.top });
        canvas.renderAll();
    });

    </script>
</div>
