<script setup>
import SearchVideoCard from '@/components/cards/SearchVideoCard.vue';
import MainLayout from '@/views/layouts/MainLayout.vue';
import { onMounted, ref } from 'vue';
import api from '@/services/api.js';

const videoData = ref({});

onMounted(() => {
  api.get('/api/video').then(response => {
    videoData.value = response.data.data;
  }).catch(error => {
    console.log(error);
  })
})

</script>

<template>
    <MainLayout>
        <section>
            <SearchVideoCard v-for="video in videoData" :id="video.id" :title="video.title" :thumb_file="video.thumbnail_path" />
        </section>
    </MainLayout>
</template>