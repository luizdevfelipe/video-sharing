<script setup>
const props = defineProps({
    modelValue: {
        type: String,
        default: () => null,
    },
    name: String,
    value: String,
    text: String,
    description: String,
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>

    <div class="flex">
        <div class="flex items-center h-5">
            <input :id="`helper-radio-${value}`" 
            aria-describedby="helper-radio-text" 
            type="radio" 
            :value="value"
            :checked="modelValue === value"
            @input="emit('update:modelValue', $event.target.value);"
            :name="name"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        </div>
        <div class="ms-2 text-sm">
            <label :for="`helper-radio-${value}`" class="font-medium text-gray-900 dark:text-gray-300">{{ text }}</label>
            <p :id="`helper-radio-text-${value}`" class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ description }}</p>
        </div>
    </div>

</template>
