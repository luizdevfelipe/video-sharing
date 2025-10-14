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

// Compute the video path based on the provided video_file prop
// e.g.: XXX.m3u8 to XXX0.ts to XXX1.ts etc.
const videoPath = computed(() => {
    if (!props.video_file) return "";
    return `${back_url}/api/video/${props.video_file}.m3u8`;
});

// Add Authorization header to video.js requests if token exists
if (videojs.Vhs) {
    videojs.Vhs.xhr.beforeRequest = function (options) {
        const token = localStorage.getItem("token");
        if (token) {
            options.headers = options.headers || {};
            options.headers["Authorization"] = `Bearer ${token}`;
        }
        return options;
    };
} else if (videojs.HttpSourceSelector) {
    videojs.Hls.xhr.beforeSend = function (options) {
        const token = localStorage.getItem("token");
        if (token) {
            options.headers = options.headers || {};
            options.headers["Authorization"] = `Bearer ${token}`;
        }
    };
}

// Initialize video.js player
onMounted(() => {
    if (videoRef.value) {
        player = videojs(videoRef.value, {
            controls: true,
            autoplay: false,
            preload: "auto",
        });

        if (videoPath.value) {
            player.src({
                src: videoPath.value,
                type: "application/x-mpegURL",
            });
        }
    }
});

// Update video source if video_file prop changes
// e.g.: XXX.m3u8 to XXX0.ts to XXX1.ts etc.
onUpdated(() => {
    if (player && videoPath.value) {
        player.src({
            src: videoPath.value,
            type: "application/x-mpegURL",
        });
    }
});

// Dispose of the player when the component is unmounted
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
