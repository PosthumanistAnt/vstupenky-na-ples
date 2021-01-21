<div class="h-full w-screen bg-pink-900">
  <div class="h-2/6 bg-yellow-500">
    <x-input for='email' type='email' placeholder='Email' height='1/2' />
    <x-input for='password' type='password' placeholder='Heslo' height='1/2' />
  </div>
  <div class="h-3/6 bg-red-500">
    @if( $credentials_error )
      <div class="bg-red-600 text-white tracking-widest text-3xl xl:text-5xl font-bolder h-full w-full text-center flex items-center justify-center"> {{ $credentials_error }} </div>
    @endif  
  </div>
  <div class="fixed inset-x-0 bottom-1 text-center xl:flex xl:justify-between xl:items-baseline bg-blue-200">
    <x-buttons.primary-button text='Přihlásit se' />
    <x-buttons.secondary-button text='Registrace' />
  </div>
</div>
