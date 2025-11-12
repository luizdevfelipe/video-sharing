<script setup>
const back_url = import.meta.env.VITE_APP_BACKEND
const props = defineProps({
    name: String,
    image: String,
})

const thumb_path = back_url + '/api/video/thumb/' + props.image;
</script>

<template>
    <RouterLink :to="`/`">
        <div class="">
            <img :src="thumb_path" class="rounded-[50%] shadow-md dark:shadow-gray-800 block w-30 h-30 max-h-full object-cover place-self-center" alt="">
            <p></p>
        </div>
    </RouterLink>
</template>
