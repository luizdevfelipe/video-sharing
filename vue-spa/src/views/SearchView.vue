<script setup>
import SearchVideoCard from '@/components/cards/SearchVideoCard.vue';
import MainLayout from '@/views/layouts/MainLayout.vue';
import ErrorSection from '@/components/sections/ErrorSection.vue';
import { getTranslations } from '@/assets/js/translations.js';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import api from '@/services/api.js';

const videoData = ref({});
const route = useRoute()

const query = route.query.q;

onMounted(() => {
  api.get('api/video/search?q=' + query).then(response => {
    videoData.value = response.data.data;
  }).catch(error => {
    console.log(error);
  })
})

const translations = getTranslations();
</script>

<template>
    <MainLayout>
        <section v-if="videoData.length > 0" class="px-5">
            <SearchVideoCard v-for="video in videoData" :id="video.id" :title="video.title" :description="video.description" :thumb_file="video.thumbnail_path" />
        </section>
        <ErrorSection v-else> {{ translations.videoNotFound }} </ErrorSection>
    </MainLayout>
</template>