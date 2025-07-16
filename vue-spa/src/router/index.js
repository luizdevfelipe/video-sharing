import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import api from '../../services/api.js';
import { user } from '@/stores/user.js'

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
      path: '/login',
      name: 'login',
      component: () => import('../views/auth/LoginView.vue'),
      meta: { autenticationPage: true }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/auth/RegisterView.vue'),
      meta: { autenticationPage: true }
    },
    {
      path: '/profile',
      name: 'profile-index',
      component: () => import('../views/profile/ProfileIndex.vue'),
      meta: { requiresAuth: true, requiresVerify: true }
    },
    {
      path: '/profile/settings',
      name: 'profile-settings',
      component: () => import('../views/profile/Settings.vue'),
      meta: { requiresAuth: true, requiresVerify: true }
    },
    {
      path: '/confirm-password',
      name: 'confirm-password',
      component: () => import('../views/auth/ConfirmPass.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/two-factor-challenge',
      name: 'two-factor-challenge',
      component: () => import('../views/auth/TwoFactorChallenge.vue'),
      meta: { public: true }
    },
    {
      path: '/forgot-password',
      name: 'forgot-password',
      component: () => import('../views/auth/ForgotPassword.vue'),
      meta: { public: true }
    },
    {
      path: '/reset-password/:token',
      name: 'reset-password',
      component: () => import('../views/auth/ResetPassword.vue'),
      meta: { public: true }
    },
    {
      path: '/verify-email',
      name: 'verify-email',
      component: () => import('../views/auth/VerifyEmail.vue'),
      meta: { requiresAuth: true, requiresVerify: true }
    }
  ],
})

router.beforeEach(async (to, from, next) => {

  if (!user.value) {
    try {
      user.value = await api.get('/api/user').then(res => res.data);
    } catch (error) {
      if (to.meta.requiresAuth) {
        return next('/login');
      }
    }
  }

  if (to.meta.public) {
    return next();
  } 

  if (to.meta.requiresAuth && !to.meta.requiresVerify) {
    return next();
  }
  
  if (to.meta.autenticationPage) {
    if (user.value) {
      return next('/');
    }
    return next();
  }

  if (to.meta.requiresVerify) {
    if (user.value && !user.value.email_verified_at && to.path !== '/verify-email') {
      return next('/verify-email');
    } else if (!user.value) {
      return next('/login');
    } else if (user.value.email_verified_at && to.path === '/verify-email') {
      return next('/');
    }
    return next();
  }

});

export default router
