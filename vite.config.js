import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Load the APP_URL from an environment variable
const APP_URL = import.meta.env.VITE_APP_URL;

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        proxy: {
            // Proxy API requests to your Laravel application
            '/api': {
                target: APP_URL,
                changeOrigin: true,
                rewrite: (path) => path.replace(/^\/api/, ''),
            },
        },
    },
});
