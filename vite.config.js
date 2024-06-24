import { defineConfig } from 'vite';

export default defineConfig({
  server: {
    proxy: {
      '/': {
        target: 'http://localhost/agentstvo', // URL PHP-сервера
        changeOrigin: true,
        rewrite: (path) => path.replace(/^// '')
      }
    }
  }
});