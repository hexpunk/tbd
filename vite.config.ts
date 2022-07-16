import { defineConfig } from "vitest/config";
import preact from "@preact/preset-vite";

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    rollupOptions: {
      manualChunks(id) {
        if (id.includes("node_modules")) {
          return "vendor";
        }
      },
    },
  },
  clearScreen: false,
  plugins: [preact()],
  test: {},
});
