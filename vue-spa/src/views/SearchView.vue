<script setup>
import SearchVideoCard from '@/components/cards/SearchVideoCard.vue';
import SearchUsersCard from '@/components/cards/SearchUsersCard.vue';
import MainLayout from '@/views/layouts/MainLayout.vue';
import ErrorSection from '@/components/sections/ErrorSection.vue';
import { getTranslations } from '@/assets/js/translations.js';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import api from '@/services/api.js';

const videoData = ref({});
const route = useRoute()
const isWaitingData = ref(true);

const query = route.query.q;

onMounted(async () => {
	await api.get('api/video/search?q=' + query).then(response => {
		videoData.value = response.data.data;
		isWaitingData.value = false;
	}).catch(error => {
		console.log(error);
	})
})

const translations = getTranslations();
</script>

<template>
	<MainLayout>
		<section class="bg-gray-200 m-2 p-2 flex justify-evenly rounded dark:bg-gray-800" v-if="videoData.length > 0 || isWaitingData">
			<SearchUsersCard v-for="video in videoData" :name="video.title" :image="video.thumbnail_path" />
		</section>
		<section v-if="videoData.length > 0 || isWaitingData" class="px-5">
			<SearchVideoCard v-for="video in videoData" :id="video.id" :title="video.title"
				:description="video.description" :thumb_file="video.thumbnail_path" />
		</section>
		<ErrorSection v-else> {{ translations.videoNotFound }} </ErrorSection>
	</MainLayout>
</template>