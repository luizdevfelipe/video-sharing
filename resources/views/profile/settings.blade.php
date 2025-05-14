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
                <a href="{{ route('password.confirm') }}" class="text-blue-500 text-xl  hover:text-blue-700 underline">Confirme a senha para ver seus códigos de autenticação</a>
            </div>
        @else
            <div class="flex justify-center gap-2 p-5" id="manageCodes">
                <x-navigation.button text="Visualizar códigos de autenticação" id="getCodes" />
                <x-navigation.button text="Gerar novos códigos de autenticação" id="newCodes" />
            </div>
        @endif
    @else
        <div id="form">
            <form id="twoFactorForm" method="POST" action="{{ route('two-factor.enable') }}">
                <x-navigation.button text="Ativar autenticação em dois fatores" />
            </form>
        </div>
    @endif
</x-layouts.main>