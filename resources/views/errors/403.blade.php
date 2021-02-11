<x-layouts.app>
    <div class="h-screen w-screen flex justify-center items-center">
        <h1 class="text-5xl font-bold tracking-wide p-8 w-full text-center">Nemáte dostatečná práva</h1>
    </div>

    <div class="fixed inset-x-0 top-1 text-center xl:flex xl:justify-between xl:items-baseline">
        @auth
            <a href="{{ url('/') }}">
                <button class="m-4 p-4 text-5xl xl:text-8xl tracking-widest font-extrabold hover:text-gray-400 bg-gray-700 hover:bg-gray-800"> Vybrat vstupenky </button>
            </a> 
        @endauth   
        
        @guest
            <a href="{{ route('login') }}">
                <button class="m-4 p-4 text-5xl xl:text-8xl tracking-widest font-extrabold hover:text-gray-400 bg-gray-700 hover:bg-gray-800"> Přihlásit </button>
            </a> 
        @endguest
    </div>
</x-layouts.app>