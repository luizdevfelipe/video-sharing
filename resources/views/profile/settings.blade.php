<x-layouts.main>
    <x-slot:head>
        @if (Auth::user()->two_factor_confirmed_at)
            @vite(['resources/js/2FA/manage2FA.js'])
        @else
            @vite(['resources/js/2FA/enable.js'])
        @endif
    </x-slot:head>

    @if (Auth::user()->two_factor_confirmed_at)
        @if (!session()->has('auth.password_confirmed_at') || time() - session('auth.password_confirmed_at') > config('auth.password_timeout', 10800))
            <div class="text-center mt-5" id="viewCodes">
                <a href="{{ route('password.confirm') }}" class="text-blue-500 text-xl  hover:text-blue-700 underline">{{ __('auth.confirm-2fa-pass') }}</a>
            </div>
        @else
            <div class="grid justify-center items-start content-start gap-2 p-5 min-h-[300px]" id="manageCodes">
                <x-navigation.button text="{{ __('auth.view2fa') }}" id="getCodes" />
                <x-navigation.button text="{{ __('auth.regenerate2fa') }}" id="newCodes" />
                <x-navigation.button color="red" text="{{ __('auth.remove2fa') }}" id="remove2FA" />
                @method('DELETE')
            </div>
        @endif
    @else
        <div id="form" class="grid justify-center items-start content-start gap-2 p-5 min-h-[300px]">
            <form id="twoFactorForm" method="POST" action="{{ route('two-factor.enable') }}">
                <x-navigation.button text="{{ __('auth.enable-2fa') }}" />
            </form>
        </div>
    @endif
</x-layouts.main>