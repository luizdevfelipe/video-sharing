<script setup>

defineProps({
    comment: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div class="border dark:border-gray-400 p-2 mt-3 rounded w-full"> <strong>{{ comment.user_name }} :</strong>
        {{ comment.content }}
    </div>
</template>