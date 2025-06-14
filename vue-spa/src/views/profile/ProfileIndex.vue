<script setup>
import MainLayout from '@/views/layouts/MainLayout.vue';
import ProfileSection from '@/components/sections/ProfileSection.vue';
import UploadVideoModal from '@/components/modals/UploadVideoModal.vue';
import Checkbox from '@/components/inputs/Checkbox.vue';
import TextInput from '@/components/inputs/TextInput.vue';
import Dropfile from '@/components/inputs/Dropfile.vue';
import Submit from '@/components/inputs/Submit.vue';
import Dropdown from '@/components/navigation/Dropdown.vue';
import { getTranslations } from '@/assets/js/translations';

import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

onMounted(() => {
    initFlowbite();
})

const translations = getTranslations();
</script>

<template>
    <MainLayout>
        <ProfileSection :name="translations.history" />
        <ProfileSection name="Playlists" />

        <UploadVideoModal :modalTitle="translations.addANewVideo" btText="+" classes="absolute z-1 left-1/2 bottom-10 -translate-x-1/2">

            <form method="POST" action="/profile/video" enctype="multipart/form-data" class="p-4 md:p-5">

            <!-- Title -->
            <TextInput :label="translations.title" name="title" :placeHolder="translations.modalVideoTitlePH" :htmlAttributes="{minlength: 10, maxlength: 255, autofocus: true}" />

            <!-- Description -->
            <TextInput :label="translations.description" name="description" :placeHolder="translations.modalVideoDescriptionPH" :htmlAttributes="{minlength: 100, maxlength: 3000}" />

             <!-- Categories -->
                <Dropdown btText="Select a category" classes="shadow-[0px_0px_0px_4px_rgba(0,0,0,0.75)] dark:shadow-[0px_0px_0px_4px_rgba(255,255,255,0.75)]">
                    <li>
                        <Checkbox name="categories[]" value="action" text="Ação" description="Filmes e vídeos repletos de adrenalina e cenas eletrizantes." />
                    </li>
                    <li>
                        <Checkbox name="categories[]" value="comedy" text="Comédia" description="Conteúdos engraçados para entreter e divertir." />
                    </li>
                    <li>
                        <Checkbox name="categories[]" value="drama" text="Drama" description="Histórias envolventes e emocionantes que exploram relações humanas." />
                    </li>
                    <li>
                        <Checkbox name="categories[]" value="documentary" text="Documentário" description="Vídeos informativos e educativos baseados em fatos reais." />
                    </li>
                    <li>
                        <Checkbox name="categories[]" value="horror" text="Terror" description="Filmes e vídeos assustadores para os fãs de suspense e medo." />
                    </li>
                    <li>
                        <Checkbox name="categories[]" value="sci-fi" text="Ficção Científica" description="Histórias futurísticas, tecnologia avançada e mundos imaginários." />
                    </li>
                    <li>
                        <Checkbox name="categories[]" value="animation" text="Animação" description="Conteúdos animados para todas as idades, desde infantis até adultos." />
                    </li>
                    <li>
                        <Checkbox name="categories[]" value="music" text="Música" description="Videoclipes, apresentações ao vivo e documentários musicais." />
                    </li>
                    <li>
                        <Checkbox name="categories[]" value="sports" text="Esportes" description="Partidas, documentários e conteúdos sobre esportes diversos." />
                    </li>
                    <li>
                        <Checkbox name="categories[]" value="education" text="Educação" description="Vídeos didáticos e tutoriais para aprendizado e desenvolvimento pessoal." />
                    </li>
                </Dropdown>

                <!-- Video -->
                <p class="text-black dark:text-white">{{ translations.videoFile }}</p>
                <Dropfile name="video" />

                <!-- Thumb -->
                <p class="text-black dark:text-white">{{ translations.thumbFile }}</p>
                <Dropfile name="thumbnail" />

                <Submit text="Add Video" />
            </form>
        </UploadVideoModal>
    </MainLayout>
</template>