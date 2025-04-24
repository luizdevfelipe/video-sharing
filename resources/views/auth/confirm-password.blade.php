<x-layouts.auth title="LogIn">
  <form id="loginForm" action="{{ route('password.confirm.store') }}" method="POST">
    <legend class="text-center text-xl font-bold">Confirme sua senha</legend>
    @csrf
    <x-inputs.text name="password" type="password" label="auth.pass-label" />

    <x-inputs.submit text="Submit" />
  </form>
</x-layouts.auth>