import { defineConfig } from 'vite';
import { resolve } from 'node:path';

export default defineConfig({
    server: {
        host: 'localhost',
        port: 1337,
        cors: true,
    },
    build: {
        outDir: 'assets/build',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: resolve(import.meta.dirname, 'assets/src/main.js'),
        },
    },
});