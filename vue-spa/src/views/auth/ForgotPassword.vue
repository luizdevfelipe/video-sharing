<script setup>
import Submit from '@/components/inputs/Submit.vue';
import TextInput from '@/components/inputs/TextInput.vue';
import AuthLayout from '@/views/layouts/AuthLayout.vue';
import api from '../../../services/api';
import { getTranslations } from '@/assets/js/translations';
import { ref, reactive } from 'vue';

const email = ref('');
const returnMessage = reactive({
    success: null,
    error: null
});

async function submitForm() {
    await api.get('/sanctum/csrf-cookie').then(response => {
        api.post('api/forgot-password', {
            email: email.value
        }).then(response => {
            returnMessage.success = response.data.message;
        }).catch(error => {
            returnMessage.error = error.response.data.message;
        })
    });
}

const translations = getTranslations();
</script>

<template>
    <AuthLayout :pageTitle="translations.authForgotPassword">
        <form id="loginForm" @submit.prevent="submitForm" method="POST">
            <legend class="text-center text-xl font-bold">{{ translations.authForgotPassword }}</legend>
            <TextInput name="email" type="email" :label="translations.authEmailLabel"
                :placeHolder="translations.authEmailPlaceholder" v-model="email" />

            <Submit :text="translations.authSubmit" />
        </form>

        <template #errors>
            <p v-if="returnMessage.errors !== null">{{ returnMessage.errors }}</p>
        </template>

        <template #success>
            <p v-if="returnMessage.success !== null">{{ returnMessage.success }}</p>
        </template>
    </AuthLayout>
</template>