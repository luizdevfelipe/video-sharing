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
        <div class="text-center">
            <img :src="thumb_path" class="rounded-[50%] shadow-md dark:shadow-gray-800 block w-25 h-25 md:w-50 md:h-50 max-h-full object-cover place-self-center" alt="">
            <p> {{  name.length > 15 ? name.slice(0, 12) + '...' : name  }} </p>
        </div>
    </RouterLink>
</template>
