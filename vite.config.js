import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        rollupOptions: {
            input: 'resources/css/simple-auth.css',
            output: {
                entryFileNames: 'simple-auth.js',
                assetFileNames: 'simple-auth.[ext]',
            },
        },
    },
});
