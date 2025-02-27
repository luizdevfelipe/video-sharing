<x-layouts.auth title="LogIn">
  <form id="loginForm" action="{{ route('login') }}" method="POST">
    @csrf
    <x-inputs.text name="email" type="email" label="auth.email-label" placeHolder="auth.email-placeholder" />

    <x-inputs.text name="password" type="password" label="auth.pass-label" />

    <div class="flex relative items-start mb-5">
      <div class="flex items-center h-5">
        <input id="remember" type="checkbox" name="remember" value="" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
      </div>
      <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('auth.remember-label') }}</label>

      <span class="absolute right-0 text-sm font-medium text-gray-900 dark:text-gray-300"><a href="{{ route('register') }}" class="text-blue-600 hover:underline dark:text-blue-500">{{ __('Register') }}</a></span>
    </div>

    <div class="flex relative items-center justify-center mb-5">
        <a href="{{ route('auth.google') }}" class="bg-gray-100 rounded-sm p-1 hover:shadow-lg dark:bg-gray-700">{{ __('auth.google-login') }}</a>       
    </div>

    <x-inputs.submit text="Submit" />
  </form>
</x-layouts.auth>