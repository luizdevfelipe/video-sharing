import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import api from '../../services/api.js';
import { user } from '@/composables/useUser.js'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: { public: true }
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/HomeView.vue'),
      meta: { public: true }
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/auth/LoginView.vue'),
      meta: { public: true }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/auth/RegisterView.vue'),
      meta: { public: true }
    },
     {
      path: '/profile',
      name: 'profile-index',
      component: () => import('../views/profile/ProfileIndex.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/profile/settings',
      name: 'profile-settings',
      component: () => import('../views/profile/Settings.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/confirm-password',
      name: 'confirm-password',
      component: () => import('../views/auth/ConfirmPass.vue'),
      meta: { requiresAuth: true }
    }
  ],
})

router.beforeEach(async (to, from, next) => {
  if (user.value != null) return next();

  try {
    user.value = await api.get('/api/user').then(res => res.data);
    next();
  } catch (error) {
    if (to.meta.requiresAuth) {
      next('/login');
    }
    next();
  }
});

export default router
