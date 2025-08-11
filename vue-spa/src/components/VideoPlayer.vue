<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import videojs from "video.js";
import "video.js/dist/video-js.css";

const videoRef = ref(null);
let player = null;

const props = defineProps({
    videoPath: {
        type: String,
        required: true
    }
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

onBeforeUnmount(() => {
    if (player) {
        player.dispose();
    }
});
</script>

<template>
    <div class="shadow-[0_5px_50px_rgba(0,0,0,0.7)] dark:shadow-[0_5px_50px_rgba(255,255,255,0.16)]">
        <video ref="videoRef" id="my-player" class="video-js vjs-fluid" controls preload="auto" autoplay
            data-setup="{}">
            <source :src="videoPath" type="application/vnd.apple.mpegurl" />
            <!-- //vjs.zencdn.net/v/oceans.mp4 -->
        </video>
    </div>
</template>