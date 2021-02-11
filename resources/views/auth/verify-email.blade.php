<x-layouts.app>
    <div class="h-screen">
        <div class="fixed top-12">
            <a href="{{ route('logout') }}" class="m-4 p-4 text-4xl xl:text-7xl tracking-widest font-extrabold hover:text-gray-400 bg-gray-700 hover:bg-gray-800"> Odhlásit </a>
        </div>

        <div class="fixed top-1/4 inset-x-0">
            <p class="text-5xl text-center p-4 tracking-wide">
                Potvrzovací email byl odeslán!
            </p>

            <p class="text-3xl text-center p-4">
                Pokud chcete pokračovat, potvrďte registraci kliknutím na odkaz v emailu.
            </p>

            @if ( session('message') )
                <div class="bg-blue-800 h-16 flex items-center justify-center text-3xl">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <div class="fixed bottom-12 inset-x-0">
            <form action="{{ route('verification.send') }}" class="flex items-center justify-center" method="POST">
                @csrf 
                <button type="submit" class="text-2xl hover:text-gray-400 p-6 bg-gray-700 hover:bg-gray-800 tracking-wide"> 
                    Znovu odeslat email
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>