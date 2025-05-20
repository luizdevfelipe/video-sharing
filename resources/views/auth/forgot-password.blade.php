<x-layouts.auth title="{{ __('auth.forgot-password') }}">
    <form id="loginForm" action="{{ route('password.email') }}" method="POST">
        <legend class="text-center text-xl font-bold">{{__('auth.forgot-password')}}</legend>
        @csrf
        <x-inputs.text name="email" type="email" label="auth.email-label" />

        <x-inputs.submit text="Submit" />
    </form>
</x-layouts.auth>