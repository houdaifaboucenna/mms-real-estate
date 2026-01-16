import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/sass/app.scss', 'resources/sass/app_ar.scss'],
            refresh: true,
        }),
    ],
});