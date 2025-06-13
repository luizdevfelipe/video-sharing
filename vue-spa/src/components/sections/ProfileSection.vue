<script setup>
import { getTranslations } from '@/assets/js/translations';
defineProps({
    name: String,
})
const translations = getTranslations();
</script>

<template>
    <section class="bg-gray-200 my-2 mx-auto rounded-md shadow-md p-1 max-w-256 dark:bg-gray-700 dark:text-white">
        <p class="mb-2">{{ name }}</p>
        <div>
            <ul class="flex flex-wrap justify-start gap-1">
                <!-- @foreach ($sources as $name => $source) -->
                <li class="p-1 rounded-sm bg-gray-100 dark:bg-gray-600"><img class="max-w-40" src="" alt="">
                    <p>{{ name }}</p>
                </li>
                <!-- @endforeach -->
                <li class="self-end"><a href="#" class="text-blue-400">{{ translations.seeMore }}</a></li>
            </ul>
        </div>
    </section>
</template>