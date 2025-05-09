<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Video Sharing' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? null }}
</head>

<body class="bg-white dark:bg-black">
    <header>
        <x-navigation.nav/>
    </header>

    <main>
        {{ $slot }}
    </main>
</body>

</html>