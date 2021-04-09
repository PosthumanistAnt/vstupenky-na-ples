<div class="h-screen pb-4 w-screen">
    <div class="xl:flex my-12 mt-36 h-2/3 w-full">
        <div id="canvas-wrapper" class="w-full xl:w-2/3 h-full" wire:ignore>
            <canvas id="canvas"></canvas>
        </div>
        <div class="w-full xl:w-1/3 h-full mt-4 xl:mt-0">
            <h2 class="text-3xl text-center tracking-wide mb-2"> Nákupní košík (TODO) </h2>
            <div class="overflow-y-scroll h-2/3 border-gray-800 border-b-2">
            <table class="w-full mt-4">
                <tr>
                    <th class="text-xl"> Číslo vstupenky </th>
                    <th class="text-xl"> Cena </th>
                    <th class="text-xl"> Smazat </th>
                </tr>
                @foreach ($selectedSeats as $selectedSeat)
                    <tr class="px-8 border-gray-800 border-b">
                        <td class="text-center"> {{ $selectedSeat->number }} </td>
                        <td class="text-center"> {{ $selectedSeat->seatType->price }} </td>
                        <td class="text-center"> <button class="p-2 px-4 m-2 bg-gray-800" wire:click="$emit('seatDeselected', '{{ $selectedSeat->id }}' )"> X </button> </td>
                    </tr>
                @endforeach
            </table>
            </div>
            <div class="flex items-center justify-evenly mt-8">
                <p class="text-center text-xl"> Celková cena: {{ $totalPrice }} </p>
                <button class="p-4 bg-gray-800" wire:click='orderSeats'> Objednat </button>
            </div>
        </div>
    </div>
    @if (session()->has('cart_empty'))
        <div class="fixed bottom-4 w-full h-16">
            <div class="bg-yellow-400 text-black text-3xl flex justify-evenly items-center h-full">
                <p> {{ session('cart_empty') }} </p>
                <button class="p-2 px-8 bg-gray-800 text-white" wire:click="unsetMessage('cart_empty')"> X </button>
            </div>
        </div>
    @endif
    @if (session()->has('order_placed'))
        <div class="fixed bottom-20 w-full h-16">
            <div class="bg-blue-400 text-black text-3xl flex justify-evenly items-center h-full">
                <p> {{ session('order_placed') }} </p>
                <button class="p-2 px-8 bg-gray-800 text-white" wire:click="unsetMessage('order_placed')"> X </button>
            </div>
        </div>
    @endif
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
        canvas.on( 'mouse:down', function( e ) {
            if( e.target?.type === "seatGroup") {
                livewire.emit( 'seatSelected', e.target.seatId );
            }
        });

        // push results from DB to js arrays
        @foreach ( $tables as $table )
            var table = new fabric.Rect({
                left: {{ $table->position_x }},
                top: {{ $table->position_y }},
                width: tableWidth,
                height: tableWidth,
                type: 'table',
                selectable: false,
                tableId: {{ $table->id }},
                fill: "black",
                seatGroups: [],
                hoverCursor: "default",
            });

            tables.push( table );
            canvas.add( table );

            @foreach( $table->seats as $seat )

                var groupPosition = evaluateSeatGroupPosition( {{ $loop->index }}, table );

                var seat = new fabric.Rect({
                    originX: 'center',
                    originY: 'center',
                    width: seatWidth,
                    height: seatWidth,
                    @if( $seat->seatType->color )
                        fill: "{{ $seat->seatType->color }}",
                    @else
                        fill: "blue",
                    @endif
                    seatId: {{ $seat->id }},
                    seatType: {{ $seat->seatType->id }},
                    type: 'seat',
                });

                var text = new fabric.Text( "{{ $seat->number }}" , {
                    fill: 'white',
                    fontSize: 10,
                    originX: 'center',
                    originY: 'center',
                    type: 'seatNumber',
                });

                var seatGroup = new fabric.Group([ seat, text ], {
                    left: groupPosition.x,
                    top: groupPosition.y,
                    selectable: false,
                    seatId: {{ $seat->id }},
                    type: 'seatGroup',
                    hoverCursor: "pointer",
                });

                table.seatGroups.push( seatGroup );
                canvas.add( table.seatGroups[ {{$loop->index }} ] );

            @endforeach
        @endforeach

        function setCorrectSeatGroupsPosition( table, group ) {
            table.seatGroups.forEach( function ( seatGroup, seatGroupIndex ) {
                var evaluatedSeatGroupPosition = evaluateSeatGroupPosition( seatGroupIndex, table, group );
                seatGroup.left = evaluatedSeatGroupPosition.x;
                seatGroup.top = evaluatedSeatGroupPosition.y;
                seatGroup.setCoords();
            });
        }

        function evaluateSeatGroupPosition(seatIndex, table, group = null) {

            var groupOffset = {
                x: 0,
                y: 0
            };

            if(group){
                groupOffset.x = group.aCoords.tl.x + group.width/2;
                groupOffset.y = group.aCoords.tl.y + group.height/2;
            }

            if( seatIndex > 7 ) {
                alert( 'Stůl ' + seatIndex + ' má přiřazených více než 8 vstupenek.');
                return;
            }

            var desiredPosition = positionsList[seatIndex];

            var tableCoords = table.calcCoords(true);

            var x = tableCoords[desiredPosition.corner].x + desiredPosition.x * seatWidth + groupOffset.x;
            var y = tableCoords[desiredPosition.corner].y + desiredPosition.y * seatWidth + groupOffset.y;

            return {
                x: x,
                y: y
            };
        }
    </script>
</div>
