import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/scss/app.scss",
                "resources/scss/home.scss",
                "resources/scss/search.scss",
                "resources/js/home.js",
                "resources/js/app.js",
                "resources/js/parkings/edit.js",
                "resources/scss/parkings/reservations/index.scss",
                "resources/scss/parkings/success-fail/fail.scss",
                "resources/scss/parkings/success-fail/success.scss",
            ],

            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
        },
    },
    build: {
        rollupOptions: {
            output: {
                // entryFileNames: `assets/[name]4.js`,
                // chunkFileNames: `assets/[name]4.js`,
                // assetFileNames: `assets/[name]4.[ext]`,
                entryFileNames: `assets/[name].[hash].js`,
                chunkFileNames: `assets/[name].[hash].js`,
                assetFileNames: `assets/[name].[hash].[ext]`,
            },
        },
    },
});
