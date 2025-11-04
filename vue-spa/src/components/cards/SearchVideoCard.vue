<script setup>
const back_url = import.meta.env.VITE_APP_BACKEND

const props = defineProps({
    id: Number,
    title: String,
    thumb_file: String,
})

const thumb_path = back_url + '/api/video/thumb/' + props.thumb_file
</script>

<template>
    <RouterLink :to="`/video/${id}`">
        <div class="bg-gray-200 mx-auto p-2 my-5 rounded-lg sm:max-w-lg h-45 dark:bg-gray-800"
            style="display: grid; grid-template: 100% / 55% 45%;">
            <img :src="thumb_path" alt="" class="rounded-lg shadow-md dark:shadow-gray-800"
                style="display: block; width: 100%; height: auto; max-height: 100%; object-fit: cover; align-self: center; justify-self: center;" />
            <div class="p-2">
                <p class="text-dark font-bold text-xl dark:text-white" :title="title">
                    <!-- {{ title.length > 10 ? title.slice(0, 13) + '…' : title }} Adicionar verificação de tamanho de página -->
                </p>
            </div>
        </div>
    </RouterLink>
</template>