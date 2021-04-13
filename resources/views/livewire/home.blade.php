<div class="w-screen h-full">
    <div class="fixed top-4 w-full">
        @foreach ($messages as $message)
            <div class="mt-4 w-full h-auto flex justify-between items-center bg-yellow-300 text-black" x-data="{ show: true }" x-show="show">
                <p class="font-bold text-xl"> {{ $message->title }} </p>
                <p class="text-lg text-center"> {{ $message->message }} </p>
                <button class="p-4 px-8 m-4 bg-gray-800 hover:bg-gray-900" @click="show = !show"> X </button>
            </div>
        @endforeach
    </div>
    <div class="m-5 my-12 mb-28 w-5/6 h-3/4 mx-auto text-xl tracking-wide">
        @if ( $event->reservation_end->isPast() )
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
