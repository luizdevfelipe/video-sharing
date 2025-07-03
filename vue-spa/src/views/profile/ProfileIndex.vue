<script setup>
import MainLayout from '@/views/layouts/MainLayout.vue';
import ProfileSection from '@/components/sections/ProfileSection.vue';
import ErrorSection from '@/components/sections/ErrorSection.vue';
import UploadVideoModal from '@/components/modals/UploadVideoModal.vue';
import Checkbox from '@/components/inputs/Checkbox.vue';
import TextInput from '@/components/inputs/TextInput.vue';
import Dropfile from '@/components/inputs/Dropfile.vue';
import Submit from '@/components/inputs/Submit.vue';
import Dropdown from '@/components/navigation/Dropdown.vue';
import { getTranslations } from '@/assets/js/translations';
import api from '../../../services/api.js';

import { ref, reactive, onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import TextArea from '@/components/inputs/TextArea.vue';

onMounted(() => {
    initFlowbite();
})

const videoFile = reactive({
    title: '',
    description: '',
    categories: [],
    file: null,
    thumb: null
});

const errors = ref(null);

async function enviarVideo() {
    if (!videoFile.file || !videoFile.thumb) {
        alert(translations.selectVideoAndThumb);
        return
    }

    const formData = new FormData();
    formData.append('title', videoFile.title);
    formData.append('description', videoFile.description);
    videoFile.categories.forEach(category => {
        formData.append('categories[]', category);
    })
    formData.append('video', videoFile.file);
    formData.append('thumbnail', videoFile.thumb);

    console.log(videoFile.categories)

    await api.post('/api/profile/video', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        videoFile.file = null;
        videoFile.thumb = null;
    }
    ).catch (error => {
        errors.value = error.response.data.errors;
    })

}

const translations = getTranslations();
</script>

<template>
    <MainLayout>
        <ProfileSection :name="translations.history" />
        <ProfileSection name="Playlists" />

        <UploadVideoModal :modalTitle="translations.addANewVideo" btText="+"
            classes="absolute z-1 left-1/2 bottom-10 -translate-x-1/2">

            <form method="POST" @submit.prevent="enviarVideo" class="p-4 md:p-5">

                <!-- Title -->
                <TextInput :label="translations.title" name="title" :placeHolder="translations.modalVideoTitlePH"
                    :htmlAttributes="{ minlength: 10, maxlength: 255, autofocus: true }" v-model="videoFile.title" />

                <!-- Description -->
                <TextArea :label="translations.description" name="description"
                    :placeHolder="translations.modalVideoDescriptionPH"
                    :htmlAttributes="{ minlength: 100, maxlength: 3000 }" v-model="videoFile.description" />

                <!-- Categories -->
                <Dropdown btText="Select a category"
                    classes="shadow-[0px_0px_0px_4px_rgba(0,0,0,0.75)] dark:shadow-[0px_0px_0px_4px_rgba(255,255,255,0.75)]">
                    <li>
                        <Checkbox name="categories" value="action" text="Ação"
                            description="Filmes e vídeos repletos de adrenalina e cenas eletrizantes."
                            v-model="videoFile.categories" />
                    </li>
                    <li>
                        <Checkbox name="categories" value="comedy" text="Comédia"
                            description="Conteúdos engraçados para entreter e divertir."
                            v-model="videoFile.categories" />
                    </li>
                    <li>
                        <Checkbox name="categories" value="drama" text="Drama"
                            description="Histórias envolventes e emocionantes que exploram relações humanas."
                            v-model="videoFile.categories" />
                    </li>
                    <li>
                        <Checkbox name="categories" value="documentary" text="Documentário"
                            description="Vídeos informativos e educativos baseados em fatos reais."
                            v-model="videoFile.categories" />
                    </li>
                    <li>
                        <Checkbox name="categories" value="horror" text="Terror"
                            description="Filmes e vídeos assustadores para os fãs de suspense e medo."
                            v-model="videoFile.categories" />
                    </li>
                    <li>
                        <Checkbox name="categories" value="sci-fi" text="Ficção Científica"
                            description="Histórias futurísticas, tecnologia avançada e mundos imaginários."
                            v-model="videoFile.categories" />
                    </li>
                    <li>
                        <Checkbox name="categories" value="animation" text="Animação"
                            description="Conteúdos animados para todas as idades, desde infantis até adultos."
                            v-model="videoFile.categories" />
                    </li>
                    <li>
                        <Checkbox name="categories" value="music" text="Música"
                            description="Videoclipes, apresentações ao vivo e documentários musicais."
                            v-model="videoFile.categories" />
                    </li>
                    <li>
                        <Checkbox name="categories" value="sports" text="Esportes"
                            description="Partidas, documentários e conteúdos sobre esportes diversos."
                            v-model="videoFile.categories" />
                    </li>
                    <li>
                        <Checkbox name="categories" value="education" text="Educação"
                            description="Vídeos didáticos e tutoriais para aprendizado e desenvolvimento pessoal."
                            v-model="videoFile.categories" />
                    </li>
                </Dropdown>

                <!-- Video -->
                <p class="text-black dark:text-white">{{ translations.videoFile }}</p>
                <Dropfile name="video" v-model="videoFile.file" />

                <!-- Thumb -->
                <p class="text-black dark:text-white">{{ translations.thumbFile }}</p>
                <Dropfile name="thumbnail" v-model="videoFile.thumb" />

                <Submit :text="translations.addANewVideo" />
            </form>

            <ErrorSection v-if="errors !== null">
                <ul v-for="error in errors" :key="error">
                    <li>{{ error[0] }}</li>
                </ul>
            </ErrorSection>
        </UploadVideoModal>
    </MainLayout>
</template>