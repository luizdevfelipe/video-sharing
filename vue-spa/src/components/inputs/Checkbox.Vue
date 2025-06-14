<script setup>
defineProps({
    name: String,
    value: String,
    text: String,
    description: String
});
</script>

<template>
    <div class="flex">
        <div class="flex items-center h-5">
            <input :id="name+'-'+value" :name="name" aria-describedby="helper-checkbox-text" type="checkbox" :value="value" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        </div>
        <div class="ms-2 text-sm">
            <label :for="name+'-'+value" class="font-medium text-gray-900 dark:text-gray-300">{{ text }}</label>
            <p :id=" name+'-description-text'" class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ description }}</p>
        </div>
    </div>
</template>