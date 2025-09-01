<script setup>
import AuthLayout from '@/views/layouts/AuthLayout.vue';
import Submit from '@/components/inputs/Submit.vue';
import TextInput from '@/components/inputs/TextInput.vue';
import api from '@/services/api.js';
import { onMounted, ref } from 'vue';
import { getTranslations } from '@/assets/js/translations.js';

const code = ref('');
const errors = ref(null);

onMounted(() => {
    const recoveryCodeElement = document.getElementById('recovery_code');
    recoveryCodeElement.addEventListener('click', function () {
        recoveryCodeElement.remove();
        document.querySelector('label[for="icode"]').innerHTML = translations.authRecoveryCodeLabel;
        document.getElementById('icode').setAttribute('placeholder', "XXXXXXXXXX-XXXXXXXXXX");
        document.getElementById('icode').setAttribute('name', 'recovery_code');
    });
})

function submitForm() {
    const data = document.getElementById('icode').getAttribute('name') === 'recovery_code' ? {recovery_code: code.value} : {code: code.value};

    api.post('api/two-factor-challenge', data
    ).then(response => {
        if (response.status === 204) {
            window.location.href = '/profile';
        }
    }).catch(error => {
        errors.value = error.response.data.message;
    })
}
const translations = getTranslations();
</script>

<template>
    <AuthLayout>
        <form id="loginForm" method="POST" @submit.prevent="submitForm">
            <legend class="text-center text-xl font-bold">{{ translations.authTwoFactorVerify }}</legend>

            <TextInput name="code" type="text" :label="translations.authTwoFactorCodeLabel" placeHolder="123456" v-model="code" :htmlAttributes="{autofocus: true}" />

            <Submit :text="translations.authSubmit" />
        </form>
        <p id="recovery_code" class="cursor-pointer text-blue-600 hover:underline dark:text-blue-500">
            {{ translations.authRecoveryCodesAuth }}</p>

        <template #errors>
            <p v-if="errors !== null">{{ errors }}</p>
        </template>
    </AuthLayout>
</template>