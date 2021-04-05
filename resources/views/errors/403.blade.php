<x-layouts.app>
    <div class="h-screen w-screen flex justify-center items-center">
        <h1 class="text-5xl font-bold tracking-wide p-8 w-full text-center">Nemáte dostatečná práva</h1>
    </div>

    <div class="fixed inset-x-0 bottom-1 text-center xl:flex xl:justify-between xl:items-baseline">
        @auth
            <a href="{{ url('/') }}">
                <button class="btn btn-primary"> Vybrat vstupenky </button>
            </a> 
        @endauth   
        
        @guest
            <a href="{{ route('login') }}">
                <button class="btn btn-primary"> Přihlásit </button>
            </a> 
        @endguest
    </div>
</x-layouts.app>