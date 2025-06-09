<script setup>
import MainLayout from '@/views/layouts/MainLayout.vue';
import VideoCard from '@/components/cards/VideoCard.vue'
</script>

<template>
  <MainLayout>
    <div class="grid justify-items-center grid-cols-1 gap-2 p-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <VideoCard/>
      <VideoCard/>
      <VideoCard/>
      <VideoCard/>
      <VideoCard/>
      <VideoCard/>
    </div>
  </MainLayout>
</template>