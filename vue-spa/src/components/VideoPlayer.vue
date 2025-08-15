<script setup>
import { ref, onMounted, onBeforeUnmount, onUpdated, computed } from "vue";
import videojs from "video.js";
import "video.js/dist/video-js.css";

const back_url = import.meta.env.VITE_APP_BACKEND;

const videoRef = ref(null);
let player = null;

const props = defineProps({
    video_file: {
        type: String,
        required: true
    }
});

const videoPath = computed(() => {
    if (!props.video_file) return "";
    return `${back_url}/api/video/${props.video_file}.m3u8`;
});

onMounted(() => {
    if (videoRef.value) {
        player = videojs(videoRef.value, {
            controls: true,
            autoplay: false,
            preload: "auto",
        });
    }
});

onUpdated(() => {
    if (player && videoPath.value) {
        player.src({
            src: videoPath.value,
            type: "application/x-mpegURL",
        });
    }
});

onBeforeUnmount(() => {
    if (player) {
        player.dispose();
    }
});
</script>

<template>
    <div>
        <video ref="videoRef" class="video-js vjs-fluid"></video>
    </div>
</template>
