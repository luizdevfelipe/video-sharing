<script setup>
import Button from '@/components/navigation/Button.vue';
import MainLayout from '../layouts/MainLayout.vue';
import { getTranslations } from '@/assets/js/translations';
import { useUserStore } from '@/stores/user.js';
import api from '../../services/api.js';
import { ref, onMounted } from 'vue';
import { getCodes, newCodes, remove2FA } from '@/assets/js/2FA/manage2FA.js';
import { enable2FA, submit2FATestCode } from '@/assets/js/2FA/enable.js';

const isPassConfirmed = ref(false);
const userStore = useUserStore();

onMounted(async () => {
    await api.get('api/confirmed-password-status').then(response => {
        isPassConfirmed.value = response.data.confirmed;
    });
})

const translations = getTranslations();
</script>

<template>
    <MainLayout>
        <div v-if="userStore.getUserData()?.two_factor_confirmed_at">
            <div v-if="!isPassConfirmed" class="text-center mt-5" id="viewCodes">
                <a href="/confirm-password" class="text-blue-500 text-xl  hover:text-blue-700 underline">{{
                    translations.confirm2FAPass }} </a>
            </div>
            <div v-else class="grid justify-center items-start content-start gap-2 p-5 min-h-[300px]" id="manageCodes">
                <Button @click="getCodes()" color="blue" :text="translations.view2FA" id="getCodes" />
                <Button @click="newCodes()" color="blue" :text="translations.regenerate2fa" id="newCodes" />
                <Button @click="remove2FA()" color="red" :text="translations.remove2fa" id="remove2FA" />
            </div>
        </div>
        <div v-else-if="!userStore.getUserData()?.google_id" id="form"
            class="grid justify-center items-start content-start gap-2 p-5 min-h-[300px]">
            
            <form id="twoFactorForm" method="post" @submit.prevent="enable2FA">
                <Button color="blue" :text="translations.enable2FA" />
            </form>
        </div>
    </MainLayout>
</template>