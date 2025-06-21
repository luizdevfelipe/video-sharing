<script setup>
import AuthLayout from '@/views/layouts/AuthLayout.vue';
import Submit from '@/components/inputs/Submit.vue';
import TextInput from '@/components/inputs/TextInput.vue';
import { getTranslations } from '@/assets/js/translations.js';
import api from '../../../services/api.js';
import { reactive } from 'vue';

const loginCredentials = reactive({
    email: '',
    password: '',
    remember: false
});

const translations = getTranslations();

async function login() {
    await api.get('/sanctum/csrf-cookie').then(response => {
        api.post('/api/login', {
            email: loginCredentials.email,
            password: loginCredentials.password,
            remember: loginCredentials.remember
        }).then(response => {
            alert(response.data.message);
            window.location.href = '/profile';
        }).catch(error => {
            alert(error.response.data.message);
        });
    });
};
</script>

<template> 
    <AuthLayout :pageTitle="translations.authLoginTitle">
        <form id="loginForm" action="/login" method="POST" @submit.prevent="login">
            <TextInput name="email" type="email" :label="translations.authEmailLabel" :placeHolder="translations.authEmailPlaceholder" v-model="loginCredentials.email" />

            <TextInput name="password" type="password" :label="translations.authPassLabel" v-model="loginCredentials.password" />

            <div class="flex relative items-start mb-5">
                <div class="flex items-center h-5">
                    <input id="remember" type="checkbox" name="remember" value="" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" v-model="loginCredentials.remember" />
                </div>
            <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ translations.authRememberLabel }}</label>

            <span class="absolute right-0 text-sm font-medium text-gray-900 dark:text-gray-300">
                <RouterLink to="/register" class="text-blue-600 hover:underline dark:text-blue-500"> {{ translations.register }} </RouterLink>
            </span>
            </div>

            <div class="flex relative items-center justify-between mb-5">
                <a href="http://localhost/auth/google" class="bg-gray-100 rounded-sm p-1 hover:shadow-lg dark:bg-gray-700">{{ translations.authGoogleLogin }}</a>

                <!-- <a href="{{ route('password.request') }}" class="bg-gray-100 rounded-sm p-1 hover:shadow-lg text-blue-600 hover:underline dark:text-blue-500 dark:bg-gray-700">{{ __('auth.forgot-password') }}</a> -->
            </div>

            <Submit :text="translations.authSubmit" />
        </form>
    </AuthLayout>
</template>