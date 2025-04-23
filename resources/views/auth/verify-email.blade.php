<x-layouts.auth>
    <p class="text-justify">{{ __('auth.verify-email') }}</p>
    <form action="{{ route('verification.send') }}" method="post">
        @csrf
        <div class="mt-5">
            <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">{{ __('auth.resend-email') }}</button>
        </div>

        <div class="mt-5">
            @if (session('status') == 'verification-link-sent')
            <div class="font-medium text-sm text-green-600">
                {{ __('auth.resend-success') }}
            </div>
            @endif
        </div>
    </form>
</x-layouts.auth>