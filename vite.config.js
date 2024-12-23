import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"

export default defineConfig({
  plugins: [
    laravel({
      input: "resources/js/app.js",
      ssr: "resources/js/ssr.js",
      refresh: true,
    }),
  ],
  //serverのところを追記
  server: {
    host: true,
    hmr: {
      host: "localhost",
    },
  },
})
