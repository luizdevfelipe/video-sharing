<x-layouts.auth title="LogIn">
  <form id="loginForm" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="mb-5">
      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('auth.email-label') }}</label>
      <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('auth.email-placeholder') }}" required />
    </div>
    <div class="mb-5">
      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('auth.pass-label') }}</label>
      <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
    </div>
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

    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Submit') }}</button>
  </form>
</x-layouts.auth>