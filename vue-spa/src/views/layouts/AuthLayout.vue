<script setup>
import {onMounted} from 'vue';

const props = defineProps({
    pageTitle: [String, null],
})
onMounted(() => {
    document.getElementById('app').className = '';
    document.getElementById('app').classList.add('flex', 'items-center', 'justify-center', 'bg-white', 'dark:bg-gray-700', 'min-h-screen')
    document.title = props.pageTitle || 'Video Sharing';
})
</script>

<template>
    <main class="w-full max-w-md p-6 mx-auto bg-gray-300 p-5 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
        <slot />

        <section id="errorsSection" class="text-center text-red-500 dark:text-red-400">
            <slot name="errors" />
            <!-- @if ($errors->any())
            <ul id="errorsList">
                @foreach ($errors->all() as $error)
                <li><strong>{{ $error }}</strong></li>
                @endforeach
            </ul>
            @endif -->
        </section>

        <section id="sessionStatus" class="mb-4 font-medium text-sm text-center text-green-600">
            <!-- @if (session('status') == 'verification-link-sent')
                {{ __('auth.resend-success') }}
            @else
                {{ session('status') }}
            @endif -->
        </section>
    </main>
</template>