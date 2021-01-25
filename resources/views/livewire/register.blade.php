<div class="h-screen w-screen bg-gray-900 text-gray-300">
    <div class="h-2/3 ">
        <x-input for="name" height="1/4" type="text" placeholder="Jméno" />
        <x-input for="email" height="1/4" type="email" placeholder="Email" />
        <x-input for="password" height="1/4" type="password" placeholder="Heslo" />
        <x-input for="password_confirmation" height="1/4" type="password" placeholder="Potvrzení hesla" />
    </div>
    <div class="fixed inset-x-0 bottom-1 text-center xl:flex xl:justify-between xl:items-baseline ">
        <x-buttons.primary-button text='Registrovat' livewireFunction='register' />
        <x-buttons.secondary-button text='Přihlášení' livewireFunction='login' />
      </div>
</div>
