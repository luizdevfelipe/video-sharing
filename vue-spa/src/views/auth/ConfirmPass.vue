<script setup>
import AuthLayout from '@/views/layouts/AuthLayout.vue';
import TextInput from '@/components/inputs/TextInput.vue';
import Button from '@/components/navigation/Button.vue';
import api from '../../../services/api.js';
import { getTranslations } from '@/assets/js/translations';
import { ref } from 'vue';

const password = ref('');
const errors = ref(null);

function confirmPass() {
    api.post('api/confirm-password', {
        password: password.value,
    }).then(response => {
        javascript:history.go(-1);
    }).catch(error => {
        errors.value = error.response.data.message;
    })
}

const translations = getTranslations();
</script>

<template>
    <AuthLayout :title="translations.confirmPassword">
        <form id="loginForm" v-on:submit.prevent="confirmPass()" method="POST">
            <legend class="text-center text-xl font-bold">{{ translations.confirmPassword }}</legend>

            <TextInput name="password" type="password" :label="translations.authPassLabel" v-model="password" />

            <Button color="blue" :text="translations.authSubmit" />
        </form>
        <template #errors>
            <p v-if="errors !== null">{{ errors }}</p>
        </template>
    </AuthLayout>
</template>