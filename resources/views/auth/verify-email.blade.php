<x-layouts.app>
    <div class="bg-gray-900 text-gray-200 w-screen h-screen">

        @if (session('message'))
            <div class="bg-blue-800 absolute top-0 left-0 h-16 w-full flex items-center justify-center text-3xl">
                {{ session('message') }}
            </div>
        @endif

        <div class="fixed top-1/4 inset-x-0">
            <p class="text-5xl text-center p-4 tracking-wide">
                Potvrzovací email byl odeslán!
            </p>
            <p class="text-3xl text-center p-4">
                Pokud chcete pokračovat, potvrďte registraci kliknutím na odkaz v emailu.
            </p>
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