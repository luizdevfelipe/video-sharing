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

        <div
            class="max-w-[1200px] m-auto grid grid-cols-1 md:grid-cols-2 md:grid-rows-1 gap-4
               bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md p-6"
        >
            <section
            id="video-data"
            class="border-b md:border-b-0 md:border-r border-gray-300 dark:border-gray-700 pr-4 pb-4 md:pb-0 md:pr-6"
            >
            <h1 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">Title</h1>
            <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
                Lorem25 -> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum et, eius magni ipsa sit
                aperiam tempora facere, reiciendis nobis eum sint incidunt placeat odit optio.
            </p>
            </section>
            <section
            id="video-comments"
            class="p-1 md:order-1 md:[grid-area:-1/1/-1/-1] border-b md:border-b-0 md:border-r border-gray-300 dark:border-gray-700 md:pl-6 md:pr-6 pb-4 md:pb-0"
            >
            <VideoCommentCard />
            </section>
            <section
            id="recommendations"
            class="p-1 md:pl-6"
            >
            <VideoRecommendationCard />
            </section>
        </div>
    </MainLayout>
</template>