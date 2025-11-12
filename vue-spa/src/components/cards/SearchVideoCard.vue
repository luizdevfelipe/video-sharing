<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
const back_url = import.meta.env.VITE_APP_BACKEND

const props = defineProps({
	id: Number,
	title: String,
	description: String,
	thumb_file: String,
})

const window_size = ref(window.innerWidth)
const thumb_path = back_url + '/api/video/thumb/' + props.thumb_file

const handleResize = () => {
	window_size.value = window.innerWidth
}

onMounted(() => {
	window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
	window.removeEventListener('resize', handleResize)
})
</script>

<template>
	<RouterLink :to="`/video/${id}`">
		<div
			class="grid bg-gray-200 mx-auto my-5 p-2 rounded-lg md:max-w-xl lg:max-w-[62.5rem] dark:bg-gray-800 h-fit lg:grid-cols-[350px_auto] grid-cols-[50%_auto]">
			<img :src="thumb_path" alt=""
				class="rounded-lg shadow-md dark:shadow-gray-800 block w-full h-full max-h-full object-cover place-self-center" />
			<div class="p-2">
				<p class="text-dark font-bold text-xl dark:text-white" :title="title">
					{{ (title.length > 25 && window_size < 1024) || (title.length > 15 && window_size < 640) ?
						title.slice(0, 13) + '…' : title }} 
				</p>
				<p class="break-all">
					{{ description }}
				</p>
			</div>
		</div>
	</RouterLink>
</template>
