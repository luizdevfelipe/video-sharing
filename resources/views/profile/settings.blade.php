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
        <a href="/confirm-password" class="text-blue-500 hover:text-blue-700 underline">Confirme a senha para ver seus códigos de autenticação</a>
        @else
        {{-- TODO: passar o id para o componente --}}
        <x-navigation.button text="Visualizar códigos de autenticação" id="getCodes" />
        <x-navigation.button text="Gerar novos códigos de autenticação" id="newCodes" />
        @endif
    @else
    <div id="form">
        <form id="twoFactorForm" method="POST" action="{{ route('two-factor.enable') }}">
            <x-navigation.button text="Ativar autenticação em dois fatores" />
        </form>
    </div>
    @endif
</x-layouts.main>