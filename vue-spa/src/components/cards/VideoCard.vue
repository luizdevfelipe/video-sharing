<script setup>
const back_url = import.meta.env.VITE_APP_BACKEND

const props = defineProps({
    id: Number,
    title: String,
    thumb_file: String,
})

const thumb_path = back_url + '/api/video/thumb/' + props.thumb_file.replace('thumbnails/', '')
</script>

<template>
    <a :href="`/video/${id}`">
        <div class="bg-gray-200 rounded-t-lg max-w-sm h-80 dark:bg-gray-800">
            <div>
                <img :src="thumb_path" alt="" class="rounded-t-lg shadow-md dark:shadow-gray-800"
                    style="max-width: 100%; max-height: 100%;" />
            </div>
            <p class="text-dark font-bold text-xl dark:text-white">{{ title }}</p>
        </div>
    </a>
</template>