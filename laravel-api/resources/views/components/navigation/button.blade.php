@php
    $colors = [
        'blue' => [
            'bg' => 'bg-blue-700',
            'hover' => 'hover:bg-blue-800',
            'focus' => 'focus:ring-blue-300',
            'dark_bg' => 'dark:bg-blue-600',
            'dark_hover' => 'dark:hover:bg-blue-700',
            'dark_focus' => 'dark:focus:ring-blue-800',
        ],
        'green' => [
            'bg' => 'bg-green-700',
            'hover' => 'hover:bg-green-800',
            'focus' => 'focus:ring-green-300',
            'dark_bg' => 'dark:bg-green-600',
            'dark_hover' => 'dark:hover:bg-green-700',
            'dark_focus' => 'dark:focus:ring-green-800',
        ],
        'red' => [
            'bg' => 'bg-red-700',
            'hover' => 'hover:bg-red-800',
            'focus' => 'focus:ring-red-300',
            'dark_bg' => 'dark:bg-red-600',
            'dark_hover' => 'dark:hover:bg-red-700',
            'dark_focus' => 'dark:focus:ring-red-800',
        ],
        'yellow' => [
            'bg' => 'bg-yellow-700',
            'hover' => 'hover:bg-yellow-800',
            'focus' => 'focus:ring-yellow-300',
            'dark_bg' => 'dark:bg-yellow-600',
            'dark_hover' => 'dark:hover:bg-yellow-700',
            'dark_focus' => 'dark:focus:ring-yellow-800',
        ],
    ];
    $color = $color ?? 'blue';
@endphp

<button id="{{ $id ?? null }}"
    class="text-white
        {{ $colors[$color]['bg'] }}
        {{ $colors[$color]['hover'] }}
        focus:ring-4 focus:outline-none
        {{ $colors[$color]['focus'] }}
        font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center
        {{ $colors[$color]['dark_bg'] }}
        {{ $colors[$color]['dark_hover'] }}
        {{ $colors[$color]['dark_focus'] }}
        cursor-pointer">
    {{ __($text) }}
</button>