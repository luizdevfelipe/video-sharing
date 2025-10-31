import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import { useUserStore } from '@/stores/user.js'

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
      path: '/search',
      name: 'search',
      component: () => import('../views/SearchView.vue'),
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
      path: '/profile/videos',
      name: 'manage-videos',
      component: () => import('../views/profile/ManageVideos.vue'),
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
    },
    {
      path: '/video/:id',
      name: 'show-video',
      component: () => import('../views/video/Render.vue'),
      meta: { public: true }
    }
  ],
})

router.beforeEach(async (to, from, next) => {
  const userStore = useUserStore();

   if (userStore.user === null) {
    try {
      await userStore.getUserData()
    } catch (e) {
      userStore.user = null
    }
  }

  if (to.meta.public) {
    return next();
  }

  if (to.meta.requiresAuth && !to.meta.requiresVerify) {
    return next();
  }

  if (to.meta.autenticationPage) {
    if (userStore.user) {
      return next('/');
    }
    return next();
  }

  if (to.meta.requiresVerify) {
    if (userStore.user && !userStore.user.email_verified_at && to.path !== '/verify-email') {
      return next('/verify-email');
    } else if (!userStore.user) {
      return next('/login');
    } else if (userStore.user.email_verified_at && to.path === '/verify-email') {
      return next('/');
    }
    return next();
  }

  return next('/');

});

export default router
