import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '@/services/api';

export const useUserStore = defineStore('user', () => {
    const user = ref(null);
    const token = ref(localStorage.getItem('token') || null);

    if (token.value) {
        api.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
    } 

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

    async function login (email, password, remember = false) {
        try {
            const res = await api.post('/api/login', { email, password, remember });
            if (res.data.token) {
                token.value = res.data.token;
                localStorage.setItem('token', res.data.token);
                api.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`;
            }
        } catch (err) {
            throw err;
        }
    }

    async function logout() {
        const result = await api.post('/api/logout')
        if (result.status === 200) {
            user.value = null;
            token.value = null;
            localStorage.removeItem('token');
            delete api.defaults.headers.common['Authorization'];
            window.location.href = '/';
        }
    }

    return { user, token, getUserData, login, logout };
});
