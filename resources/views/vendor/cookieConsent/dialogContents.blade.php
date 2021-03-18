<div class="js-cookie-consent cookie-consent w-full h-full fixed top-0 bg-yellow-300 text-black text-center">

    <span class="cookie-consent__message block text-3xl mx-auto my-8">
        {!! trans('cookieConsent::texts.message') !!}
    </span>
    {{-- 
    lol
    <img src=" {{ asset('images/cookie-man.png') }}" alt="lol" class="absolute bottom-32 right-4"> 
    --}}
    <button class="js-cookie-consent-agree cookie-consent__agree block absolute bottom-16 inset-x-0 text-4xl bg-yellow-200 p-4 mx-auto font-bold tracking-wide ">
        {{ trans('cookieConsent::texts.agree') }}
    </button>

</div>
