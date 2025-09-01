<script setup>
import TextInput from '@/components/inputs/TextInput.vue';
import AuthLayout from '../layouts/AuthLayout.vue';
import Submit from '@/components/inputs/Submit.vue';
import api from '@/services/api';
import { getTranslations } from '@/assets/js/translations.js';
import { useRoute } from 'vue-router';
import { ref } from 'vue';

const route = useRoute()

const token = route.params.token;
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const errors = ref(null);

function submitForm() {
    api.post('/api/reset-password', {
        token: token,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value
    },
    ).then(response => {
        alert(response.data.message);
        window.location.href = '/login';
    }).catch(error => {
        errors.value = error.response.data.message;
    })
}
const translations = getTranslations();
</script>

<template>
    <AuthLayout :pageTitle="translations.authResetPassword">
        <form id="registerForm" @submit.prevent="submitForm" method="POST">
            <TextInput name="email" type="email" :label="translations.authEmailLabel"
                :placeHolder="translations.authEmailPlaceholder" v-model="email" />

            <TextInput name="password" type="password" :label="translations.authPassLabel" v-model="password" />

            <TextInput type="password" name="password_confirmation" :label="translations.authPassConfirmLabel"
                v-model="password_confirmation" />

            <Submit :text="translations.authSubmit" />
        </form>
        <template #errors>
            <p v-if="errors !== null">{{ errors }}</p>
        </template>
    </AuthLayout>
</template>