<x-layouts.auth>
    <form id="registerForm" action="{{ route('register') }}" method="POST">
        @csrf

        <x-inputs.text name="email" type="email" label="auth.email-label" placeHolder="auth.email-placeholder" />

        <x-inputs.text name="name" type="name" label="auth.name-label" placeHolder="auth.name-placeholder" />

        <x-inputs.text name="password" type="password" label="auth.pass-label" />

        <x-inputs.text name="password_confirmation" type="password" label="auth.passconfirm-label"/>

        <x-inputs.submit text="Submit"/>
    </form>
</x-layouts.auth>