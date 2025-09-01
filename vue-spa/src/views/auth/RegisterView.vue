<script setup>
import AuthLayout from '@/views/layouts/AuthLayout.vue';
import Submit from '@/components/inputs/Submit.vue';
import TextInput from '@/components/inputs/TextInput.vue';
import { getTranslations } from '@/assets/js/translations.js';
import api from '@/services/api.js';
import { reactive } from 'vue';

const userData = reactive({
    email: '',
    name: '',
    password: '',
    password_confirmation: '',
    errors: null
})

async function createAccount() {
    await api.get('/sanctum/csrf-cookie').then(response => {
        api.post('/api/register', {
            email: userData.email,
            name: userData.name,
            password: userData.password,
            password_confirmation: userData.password_confirmation
        }).then(response => {
            alert(response.data.message);
            window.location.href = '/profile';
        }).catch(error => {
            userData.errors = error.response.data.message;
        });
    });
}

const translations = getTranslations();
</script>    

<template>
    <AuthLayout :pageTitle="translations.authRegisterTitle">
            <form id="registerForm" action="/register" method="POST" @submit.prevent="createAccount">
            <TextInput name="email" type="email" :label="translations.authEmailLabel" :placeHolder="translations.authEmailPlaceholder" v-model="userData.email" />
            
            <TextInput name="name" type="name" :label="translations.authNameLabel" :placeHolder="translations.authNamePlaceholder" v-model="userData.name" />
            
            <TextInput name="password" type="password" :label="translations.authPassLabel" v-model="userData.password" />

            <TextInput name="password_confirmation" type="password" :label="translations.authPassConfirmLabel" v-model="userData.password_confirmation" />

            <Submit :text="translations.authSubmit" />
        </form>

        <template #errors>
            <p v-if="userData.errors !== null"> {{ userData.errors }}</p>
        </template>
    </AuthLayout>
</template>