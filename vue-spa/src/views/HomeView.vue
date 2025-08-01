<script setup>
import MainLayout from '@/views/layouts/MainLayout.vue';
import VideoCard from '@/components/cards/VideoCard.vue'
import { onMounted, ref } from 'vue';
import api from '../../services/api.js';

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
    <div class="grid justify-items-center grid-cols-1 gap-2 p-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <VideoCard v-for="video in videoData" :id="video.id" :title="video.title" :thumb_file="video.thumbnail_path" />
    </div>
  </MainLayout>
</template>