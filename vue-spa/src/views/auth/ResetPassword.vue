<script setup>

import TextInput from '@/components/inputs/TextInput.vue';
import AuthLayout from '../layouts/AuthLayout.vue';
import { getTranslations } from '@/assets/js/translations.js';

// request()->route('token')

const translations = getTranslations();
</script>

<template>
    <AuthLayout :pageTitle="translations.authResetPassword">
        <form id="registerForm" method="POST">
            <TextInput name="email" type="email" :label="translations.authEmailLabel"
                :placeHolder="translations.authEmailPlaceholder" v-model="email" />

            <TextInput name="password" type="password" :label="translations.authPassLabel"
                v-model="password" />

            <TextInput type="password" name="password_confirmation" :label="translations.authPassConfirmLabel" v-model="password_confirmation" />

            <Submit :text="translations.authSubmit" />
        </form>
    </AuthLayout>
</template>