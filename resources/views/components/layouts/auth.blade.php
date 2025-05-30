<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Video Sharing' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? null }}
</head>

<body class="flex items-center justify-center bg-white dark:bg-gray-700 min-h-screen">
    <main class="w-full max-w-md p-6 mx-auto bg-gray-300 p-5 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
        {{ $slot }}
        <section id="errorsSection" class="text-center text-red-500 dark:text-red-400">
            @if ($errors->any())
            <ul id="errorsList">
                @foreach ($errors->all() as $error)
                <li><strong>{{ $error }}</strong></li>
                @endforeach
            </ul>
            @endif
        </section>

        @if (session('status'))
        <section id="sessionStatus" class="mb-4 font-medium text-sm text-center text-green-600">
             @if (session('status') == 'verification-link-sent')
                {{ __('auth.resend-success') }}
            @else
                {{ session('status') }}
            @endif
            
        </section>
        @endif
    </main>
</body>

</html>