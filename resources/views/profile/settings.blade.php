<x-layouts.main>
    <x-slot:head>
        @vite(['resources/js/2FA/enable.js'])
    </x-slot:head>

    @if (Auth::user()->two_factor_confirmed_at)
        já eativo

        @if (!session()->has('auth.password_confirmed_at') ||
        time() - session('auth.password_confirmed_at') > config('auth.password_timeout', 10800))

        <a href="/confirm-password" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-4">Confirme a senha para ver seus códigos de autenticação</a>
        @else
        <button id="getCodes" class="btn btn-primary">Visualizar códigos de recuperação</button>
        <button id="newCodes" class="btn btn-warning">Gerar novos códigos</button>
        @endif

    @else
    <div id="form">
        <form id="twoFactorForm" method="POST" action="{{ route('two-factor.enable') }}">
            <x-navigation.button text="Ativar autenticação em dois fatores" />
        </form>
    </div>

    @endif
</x-layouts.main>