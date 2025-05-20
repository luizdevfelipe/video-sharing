<x-layouts.auth title="{{ __('auth.register') }}">
    <form id="registerForm" action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <x-inputs.text name="email" type="email" label="auth.email-label" placeHolder="auth.email-placeholder" />

        <x-inputs.text name="password" type="password" label="auth.pass-label" />

        <x-inputs.text name="password_confirmation" type="password" label="auth.passconfirm-label"/>

        <x-inputs.submit text="Submit"/>
    </form>
</x-layouts.auth>