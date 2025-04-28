<x-layouts.main>
    <x-slot:head>
        @vite(['resources/js/2FA/enable.js'])
    </x-slot:head>

    <form id="twoFactorForm" method="POST" action="{{ route('two-factor.enable') }}">
        @csrf
        <x-navigation.button text="Ativar autenticação em dois fatores" />
    </form>
</x-layouts.main>