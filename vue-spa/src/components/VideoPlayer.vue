<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import videojs from "video.js";
import "video.js/dist/video-js.css";

const videoRef = ref(null);
let player = null;

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
    <div class="shadow-[0_35px_35px_rgba(0,0,0,0.25)] dark:shadow-[0_35px_35px_rgba(255,255,255,0.25)]">
        <video ref="videoRef" id="my-player" class="video-js vjs-fluid" controls preload="auto"
            data-setup="{}">
            <source src="//vjs.zencdn.net/v/oceans.mp4" type="video/mp4" />
        </video>
    </div>
</template>