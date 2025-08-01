<script setup>
import VideoPlayer from '@/components/VideoPlayer.vue';
import MainLayout from '../layouts/MainLayout.vue';

</script>

<template>
    <MainLayout>
        <!-- Main -->

        <div id="video-container" class="mx-auto my-5 w-[100dvw] md:w-[80dvw]">
            <VideoPlayer />
        </div>

    </MainLayout>
</template>