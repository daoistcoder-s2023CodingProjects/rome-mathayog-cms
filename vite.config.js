import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  define: {
    'process.env.APP_URL': JSON.stringify('http://18.140.194.136'), // Set your desired APP_URL here
  },
});
