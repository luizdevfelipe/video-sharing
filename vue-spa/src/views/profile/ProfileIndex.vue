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
import TextArea from '@/components/inputs/TextArea.vue';
import api from '../../../services/api.js';
import SuccessNotification from '@/components/notification/SuccessNotification.vue';
import { getTranslations } from '@/assets/js/translations';
import { ref, reactive, onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import { toggleModal } from '@/assets/js/modal.js';
import LoadingComponent from '@/components/icons/LoadingComponent.vue';

const availableCategories = ref([]);
const errors = ref(null);
const uploadStatus = ref(false);
const isProcessing = ref(false);

const videoFile = reactive({
    title: '',
    description: '',
    categories: [],
    file: null,
    thumb: null
});

onMounted(async () => {
    initFlowbite();

    if (availableCategories.value.length == 0) {
        await api.get('/api/categories').then(response => {
            availableCategories.value = response.data;
        }).catch(error => {
            errors.value = error.response.data.errors;
        })
    }
})

async function enviarVideo() {
    if (!videoFile.file || !videoFile.thumb) {
        alert(translations.selectVideoAndThumb);
        return
    }
    isProcessing.value = true;

    const formData = new FormData();
    formData.append('title', videoFile.title);
    formData.append('description', videoFile.description);
    videoFile.categories.forEach(category => {
        formData.append('categories[]', category);
    })
    formData.append('video', videoFile.file);
    formData.append('thumbnail', videoFile.thumb);
    
    await api.post('/api/profile/video', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        videoFile.file = null;
        videoFile.thumb = null;
        videoFile.title = '';
        videoFile.description = '';
        videoFile.categories = [];
        toggleModal('crud-modal');
        errors.value = null;
        uploadStatus.value = true;
    }
    ).catch(error => {
        errors.value = error.response.data.errors;
    })

    isProcessing.value = false;
}

const translations = getTranslations();
</script>

<template>
    <MainLayout>
        <SuccessNotification v-if="uploadStatus" id="uploadedSuccessfully"
            :message="translations.videoUploadedSuccessfully" v-model="uploadStatus" />

        <ProfileSection :name="translations.history" />
        <ProfileSection name="Playlists" />

        <UploadVideoModal modalTarget="crud-modal" :modalTitle="translations.addANewVideo" btText="+"
            classes="absolute z-1 left-1/2 bottom-10 -translate-x-1/2">

            <form method="POST" @submit.prevent="enviarVideo" class="p-4 md:p-5">

                <!-- Title -->
                <TextInput :label="translations.title" name="title" :placeHolder="translations.modalVideoTitlePH"
                    :htmlAttributes="{ minlength: 10, maxlength: 35, autofocus: true }" v-model="videoFile.title" />

                <!-- Description -->
                <TextArea :label="translations.description" name="description"
                    :placeHolder="translations.modalVideoDescriptionPH"
                    :htmlAttributes="{ minlength: 100, maxlength: 3000 }" v-model="videoFile.description" />

                <!-- Categories -->
                <Dropdown btText="Select a category"
                    classes="shadow-[0px_0px_0px_4px_rgba(0,0,0,0.75)] dark:shadow-[0px_0px_0px_4px_rgba(255,255,255,0.75)]">
                    <li v-for="availableCategory in availableCategories">
                        <Checkbox name="categories" :value="availableCategory.name" :text="availableCategory.title"
                            :description="availableCategory.description" v-model="videoFile.categories" />
                    </li>
                </Dropdown>

                <!-- Video -->
                <p class="text-black dark:text-white">{{ translations.videoFile }}</p>
                <Dropfile name="video" fileTypes="MP4, MOV, AVI, WMV, MAX: 20MB" v-model="videoFile.file" />

                <!-- Thumb -->
                <p class="text-black dark:text-white">{{ translations.thumbFile }}</p>
                <Dropfile name="thumbnail" fileTypes="JPG, JPEG, PNG, MAX: 2MB" v-model="videoFile.thumb" />

                <Submit v-if="!isProcessing" :text="translations.addANewVideo" />

                <LoadingComponent v-if="isProcessing" :text="translations.uploadingVideo" />

            </form>

            <ErrorSection v-if="errors !== null">
                <ul v-for="error in errors" :key="error">
                    <li>{{ error[0] }}</li>
                </ul>
            </ErrorSection>
        </UploadVideoModal>
    </MainLayout>
</template>