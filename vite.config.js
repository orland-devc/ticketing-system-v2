import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        // host: '0.0.0.0',
        // port: 5174,
        // hmr: {
        //     host: '192.168.43.228', 
        // },
    },
});
// run with php artisan serve --host="192.168.43.228" --port="8000"
// php artisan config:clear
// php artisan cache:clear
// php artisan route:clear
// php artisan view:clear
// composer dump-autoload
// php artisan serve

//> Http::post(env('GEMINI_API_URL').'?key='.env('GEMINI_API_KEY'), ['contents' => [['role' => 'user', 'parts' => [['text' => 'do a short for loop']]]]])->json();