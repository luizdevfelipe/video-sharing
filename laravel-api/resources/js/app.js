// Importing necessary packages and styles
import './bootstrap';
import 'flowbite';
import.meta.glob([
    '../images/**'
]);
import $ from 'jquery';
import { createApp } from 'vue';
import App from './components/App.vue';

// Defining global variables
window.$ = window.jQuery = $;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

createApp(App).mount('#app');