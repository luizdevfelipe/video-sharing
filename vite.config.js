import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js', 
                'resources/js/2FA/enable.js',
                'resources/js/2FA/manage2FA.js',
                'resources/js/routes.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {  
        alias: {  
            '@': '/resources',  
        },  
    },
});
