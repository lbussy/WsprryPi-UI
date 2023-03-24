import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import viteCompression from 'vite-plugin-compression';

// eslint-disable-next-line no-undef
const path = require("path");

// let localServer = "http://0.0.0.0:8000/";
const localServer = "http://192.168.1.3/";
export default defineConfig({
  base: "./",
  plugins: [
    vue(),
    viteCompression({ verbose: false })
  ],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
    },
  },
  build: {
    rollupOptions: {
      output: {
        entryFileNames: `[name].js`,   // works
        chunkFileNames: `[name].js`,   // works
        assetFileNames: `[name].[ext]` // does not work for images
      }
    }
  },
  server: {
    proxy: {
      '^/wspr/.*': {
        target: localServer,
        changeOrigin: true,
      },
    }
  }
})
