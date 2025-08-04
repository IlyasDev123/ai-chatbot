import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react"; // Use vue if you're using Vue.js

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.jsx"], // or app.vue for Vue
            refresh: true,
        }),
        react(), // or vue() for Vue.js
    ],
    server: {
        host: "0.0.0.0",
        hmr: {
            host: "localhost",
        },
    },
});
