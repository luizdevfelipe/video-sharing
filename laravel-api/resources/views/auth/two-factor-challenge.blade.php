<x-layouts.auth title="2FA">
  <x-slot:head>
    <script type="module">
      $(document).ready(function() {
        $('#recovery_code').on('click', function() {
          $('#recovery_code').remove();
          $('label[for="icode"]').text("{{__('auth.recovery_code_label')}}");
          $('#icode').attr('placeholder', "XXXXXXXXXX-XXXXXXXXXX");
          $('#icode').attr('name', 'recovery_code');
        });
      });
    </script>
  </x-slot:head>

  <form id="loginForm" action="{{ route('two-factor.login.store') }}" method="POST">
    <legend class="text-center text-xl font-bold">{{__('auth.two-factor-verify')}}</legend>
    @csrf
    <x-inputs.text name="code" type="text" label="auth.two-factor-code-label" placeHolder="123456" />

    <x-inputs.submit text="Submit" />
  </form>
  <p id="recovery_code" class="cursor-pointer text-blue-600 hover:underline dark:text-blue-500">{{__('auth.recovery_codes_auth')}}</p>
</x-layouts.auth>