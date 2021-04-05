<div class="w-screen h-full">
    <div class="m-5 my-12 w-5/6 h-3/4 mx-auto text-xl tracking-wide">
        @if ( $event->reservation_start->isPast() )
            <div class="m-12 mt-28 p-4 bg-red-600 text-4xl text-center font-bold tracking-wider">
                PLES JIŽ PROBĚHL :(
            </div>
        @endif
        <h1 class="m-5 mb-12 text-4xl text-center font-bold tracking-wide"> Rezervace vstupenek </h1>
        <h2 class="m-4 mb-8 text-center"> Rezervace na reprezentační ples Obchodní akademie, Vyšší odborné školy a Jazykové školy s právem státní jazykové zkoušky Uherské Hradiště </h2>
        <p class="m-4"> Začátek rezervace <b> {{ $event->reservation_start->format('d. m. Y H:i:s') }} </b> </p>
        <p class="m-4"> Konec rezervace <b> {{ $event->reservation_end->format('d. m. Y H:i:s') }} </b> </p>
        <p class="m-4"> Začátek plesu <b> {{ $event->ball_start->format('d. m. Y H:i:s') }} </b> </p>
        <p class="m-4 my-8"> {!! $event->description !!} </p>
    </div>

    <div class="fixed inset-x-0 bottom-1 text-center">
        <button class="btn btn-primary" wire:click="reserve"> Pokračovat </button>
    </div>
</div>
