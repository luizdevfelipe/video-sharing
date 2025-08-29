import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '@/services/api';

export const useUserStore = defineStore('user', () => {
    const user = ref(null);

    async function getUserData(force = false) {
        if (!user.value || force) {
            try {
                const res = await api.get('/api/user');
                user.value = res.data;
            } catch {
                user.value = null;
            }
        }
        return user.value;
    }

    async function logout() {
        const result = await api.post('/api/logout')
        if (result.status === 204) {
            user.value = null;
        }
    }

    return { user, getUserData, logout };
});
