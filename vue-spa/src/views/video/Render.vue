<script setup>
import VideoPlayer from '@/components/VideoPlayer.vue';
import MainLayout from '../layouts/MainLayout.vue';
import VideoCommentCard from '@/components/cards/VideoCommentCard.vue';
import VideoRecommendationCard from '@/components/cards/VideoRecommendationCard.vue';

</script>

<template>
    <MainLayout>
        <!-- Main -->

        <section id="video-container" class="mx-auto my-5 w-[100dvw] md:w-[80dvw]">
            <VideoPlayer />
        </section>

        <div class="grid">
            <section id="video-data">
                <h1>Title</h1>
                <p>Lorem25 -> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum et, eius magni ipsa sit
                    aperiam tempora facere, reiciendis nobis eum sint incidunt placeat odit optio.</p>
            </section>
            <section id="video-comments" class="p-1">
                <VideoCommentCard />
            </section>
            <section id="recommendations" class="p-1">
                <VideoRecommendationCard />
            </section>
        </div>
    </MainLayout>
</template>