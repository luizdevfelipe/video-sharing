<script setup>
import AuthLayout from '@/views/layouts/AuthLayout.vue';
import Submit from '@/components/inputs/Submit.vue';
import TextInput from '@/components/inputs/TextInput.vue';
import { getTranslations } from '@/assets/js/translations.js';

const translations = getTranslations();
</script>    

<template>
    <AuthLayout :pageTitle="translations.authRegisterTitle">
            <form id="registerForm" action="/register" method="POST">
            <TextInput name="email" type="email" :label="translations.authEmailLabel" :placeHolder="translations.authEmailPlaceholder" />
            
            <TextInput name="name" type="name" :label="translations.authNameLabel" :placeHolder="translations.authNamePlaceholder" />
            
            <TextInput name="password" type="password" :label="translations.authPassLabel"/>

            <TextInput name="password_confirmation" type="password" :label="translations.authPassConfirmLabel"/>

            <Submit :text="translations.authSubmit" />
        </form>
    </AuthLayout>
</template>