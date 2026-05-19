import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/css/shop.css', 'resources/js/app.js', 
                'resources/css/authorpage.css', 'resources/css/contact.css', 'resources/css/edit.css',
                'resources/css/header.css', 'resources/css/login.css', 'resources/css/register.css', 'resources/css/rolepage.css'

            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});