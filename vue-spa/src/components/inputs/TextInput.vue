<script setup>
defineProps({
    name: String,
    type: [String, null],
    label: String,
    placeHolder: [String, null],
    htmlAttributes: {
        type: Object,
        default: () => ({})
    }
})
</script>

<template>
    <div class="mb-5">
        <label :for="'i'+name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ label }}</label>
        <input :type="(type ? type : 'text')" :id="'i'+name" :name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" :placeholder="placeHolder" required v-bind="htmlAttributes"/>
    </div>
</template>