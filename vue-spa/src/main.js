import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

document.documentElement.lang = import.meta.env.VITE_APP_LOCALE || 'en';

const app = createApp(App)

app.use(router)

app.mount('#app')
