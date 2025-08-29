import './assets/main.css';
import { createPinia } from 'pinia';
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

document.documentElement.lang = import.meta.env.VITE_APP_LOCALE || 'en';

const pinia = createPinia();
const app = createApp(App)

app.use(router)
app.use(pinia);

app.mount('#app')
