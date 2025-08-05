<script setup>
import VideoPlayer from '@/components/VideoPlayer.vue';
import MainLayout from '../layouts/MainLayout.vue';
import VideoCommentCard from '@/components/cards/VideoCommentCard.vue';
import VideoRecommendationCard from '@/components/cards/VideoRecommendationCard.vue';
import AccordionComponent from '@/components/AccordionComponent.vue';
import { getTranslations } from '@/assets/js/translations';

function postComment() {
    // /api/videos/${videoId}/comments
}

const translations = getTranslations();
</script>

<template>
    <MainLayout>
        <!-- Main -->
        <section id="video-container" class="mx-auto my-5 w-[100dvw] md:w-[80dvw]">
            <VideoPlayer />
        </section>

        <div class="max-w-[1200px] m-auto grid grid-cols-1 md:grid-cols-2 md:grid-rows-1 gap-4
               bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md p-6">
            <section id="video-data"
                class="border-b md:border-b-0 md:border-r border-gray-300 dark:border-gray-700 pr-4 pb-4 md:pb-0 md:pr-6">
                <h1 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">Title</h1>
                <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
                    Lorem25 -> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum et, eius magni ipsa sit
                    aperiam tempora facere, reiciendis nobis eum sint incidunt placeat odit optio.
                </p>
            </section>
            <section id="video-comments"
                class="p-1 md:order-1 md:[grid-area:-1/1/-1/-1] border-b md:border-b-0 border-gray-300 dark:border-gray-700 md:pl-6 md:pr-6 pb-4 md:pb-0">

                <AccordionComponent :title="translations.comments">
                    <form @submit.prevent="postComment" method="post">
                        <textarea
                            class="w-full p-2 mb-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            :placeholder="translations.writeComment" required></textarea>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                            {{ translations.postComment }}
                        </button>
                    </form>

                    <VideoCommentCard />

                </AccordionComponent>

            </section>
            <section id="recommendations" class="p-1 md:pl-6">
                <VideoRecommendationCard />
            </section>
        </div>
    </MainLayout>
</template>