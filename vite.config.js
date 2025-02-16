import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 'resources/js/app.js',
                'resources/css/index.css',
                'resources/css/posts_list.css',
                'resources/css/write_post.css',
                'resources/css/read_post.css'
            ],
            refresh: true,
        }),
    ],
});
