<script setup>
import Button from '@/components/navigation/Button.vue';
import MainLayout from '../layouts/MainLayout.vue';
import { getTranslations } from '@/assets/js/translations';
import { user } from '@/composables/useUser.js'
import api from '../../../services/api.js';
import { ref, onMounted } from 'vue';

const isPassConfirmed = ref(false);

onMounted(async () => {
    await api.get('api/confirmed-password-status').then(response => {
        isPassConfirmed.value = response.data.confirmed;
    });

    if (user.value.two_factor_confirmed_at) {
        await import('@/assets/js/2FA/manage2FA.js');
    } else {
        await import('@/assets/js/2FA/enable.js');
    }
})

const translations = getTranslations();
</script>

<template>
    <MainLayout>
        <div v-if="user.two_factor_confirmed_at">
            <div v-if="!isPassConfirmed" class="text-center mt-5" id="viewCodes">
                <a href="/confirm-password" class="text-blue-500 text-xl  hover:text-blue-700 underline">{{
                    translations.confirm2FAPass }} </a>
            </div>
            <div v-else class="grid justify-center items-start content-start gap-2 p-5 min-h-[300px]" id="manageCodes">
                <Button color="blue" :text="translations.view2FA" id="getCodes" />
                <Button color="blue" :text="translations.regenerate2fa" id="newCodes" />
                <Button color="red" :text="translations.remove2fa" id="remove2FA" />
            </div>
        </div>
        <div v-else-if="!user.google_id" id="form"
            class="grid justify-center items-start content-start gap-2 p-5 min-h-[300px]">
            <form id="twoFactorForm" method="POST" action="/two-factor.enable">
                <Button color="blue" :text="translations.enable2FA" />
            </form>
        </div>
    </MainLayout>
</template>