<div class="h-screen w-screen">
  <form class="h-full w-full" wire:submit.prevent>
    <div class="h-2/6 ">
      <x-input for='email' type='email' placeholder='Email' height='1/2' />
      <x-input for='password' type='password' placeholder='Heslo' height='1/2' />
    </div>

    <div class="h-2/6">
      @if( $credentials_error )
        <div class="bg-red-700 text-white tracking-widest text-3xl xl:text-5xl font-bolder h-full w-full text-center flex items-center justify-center"> {{ $credentials_error }} </div>
      @endif  
    </div>

    <div class="fixed inset-x-0 bottom-1 text-center xl:flex xl:justify-between xl:items-baseline">
      <button class="btn btn-primary" wire:click="login"> Přihlásit </button>
      <button class="btn btn-secondary" wire:click="register"> Registrace </button>
    </div>
  </form>
  @include('cookieConsent::index')
</div>
