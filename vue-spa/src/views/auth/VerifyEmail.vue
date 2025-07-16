<script setup>
import AuthLayout from '@/views/layouts/AuthLayout.vue';
import { getTranslations } from '@/assets/js/translations.js';
import api from '../../../services/api.js';
import { reactive } from 'vue';

const returnMessage = reactive({
    success: null,
    error: null
});

function formSubmit() {
    api.post('api/email/verification-notification')
    .then(response => {
        returnMessage.success = translations.emailSent;
        returnMessage.error = null;
    }).catch(error => {
        returnMessage.error = error.response.data.message;
        returnMessage.success = null;
    });
}

const translations = getTranslations();
</script>

<template>
    <AuthLayout :pageTitle="translations.authConfirmEmail">
        <p class="text-justify">{{ translations.authConfirmEmail }}</p>
        <form @submit.prevent="formSubmit" method="post">
            <div class="mt-5">
                <button type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center my-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">{{
                        translations.authResentEmail }}</button>
            </div>
        </form>

        <template #errors>
            <p v-if="returnMessage.error !== null">{{ returnMessage.error }}</p>
        </template>

        <template #success>
            <p v-if="returnMessage.success !== null">{{ returnMessage.success }}</p>
        </template>
    </AuthLayout>
</template>