import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import viteCompression from 'vite-plugin-compression';

// eslint-disable-next-line no-undef
const path = require("path");

// let localServer = "http://0.0.0.0:8000/";
const localServer = "http://192.168.1.3/";
export default defineConfig({
  base: "./",
  publicPath: process.env.NODE_ENV === 'production' ? '/wspr' : './',
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
    open: '/config',
    proxy: {
      '/wspr_ini.php': {
        target: localServer,
        changeOrigin: true,
        secure: false,
        rewrite: function (path, req) { return path.replace('/', '/wspr/') },
        configure: (proxy, _options) => {
          proxy.on('error', (err, _req, _res) => {
            console.log('proxy error', err);
          });
          proxy.on('proxyReq', (proxyReq, req, _res) => {
            console.log('Sending Request to the Target:', req.method, req.url);
          });
          proxy.on('proxyRes', (proxyRes, req, _res) => {
            console.log('Received Response from the Target:', proxyRes.statusCode, req.url);
          });
        },
      },
      '/wspr_log.php': {
        target: localServer,
        changeOrigin: true,
        secure: false,
        rewrite: function (path, req) { return path.replace('/', '/wspr/') },
        configure: (proxy, _options) => {
          proxy.on('error', (err, _req, _res) => {
            console.log('proxy error', err);
          });
          proxy.on('proxyReq', (proxyReq, req, _res) => {
            console.log('Sending Request to the Target:', req.method, req.url);
          });
          proxy.on('proxyRes', (proxyRes, req, _res) => {
            console.log('Received Response from the Target:', proxyRes.statusCode, req.url);
          });
        },
      },
    },
  }
})
