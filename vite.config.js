import { defineConfig } from 'vite'
import { resolve } from 'path'

export default defineConfig(({ mode }) => ({
  build: {
    outDir: 'assets',
    watch: mode === 'development' ? {
      exclude: [
        'assets/**',
        'node_modules/**',
        '.git/**',
        '**/*.log',
        '**/*.tmp'
      ]
    } : null,
    rollupOptions: {
      input: {
        app: resolve(__dirname, 'src/js/app.js'),
        style: resolve(__dirname, 'src/css/app.css')
      },
      output: {
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name.endsWith('.css')) {
            return 'css/[name][extname]'
          }
          return 'assets/[name][extname]'
        }
      }
    },
    emptyOutDir: false,
    manifest: false
  },
  server: {
    port: 3000,
    open: false,
    hmr: true,
    watch: {
      usePolling: true
    }
  },
  css: {
    postcss: './postcss.config.js'
  }
}))
