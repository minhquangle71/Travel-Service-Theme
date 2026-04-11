const { defineConfig } = require("vite");
const path = require("path");

const vitePort = Number(process.env.VITE_PORT || 5173);
const wpPort = Number(
  process.env.NGINX_PORT || process.env.WORDPRESS_PORT || 81,
);
const viteHost = process.env.VITE_HOST || "127.0.0.1";
const viteProtocol = process.env.VITE_PROTOCOL || "http";
const wpHost = process.env.WORDPRESS_HOST || "127.0.0.1";
const wpProtocol = process.env.WORDPRESS_PROTOCOL || "http";

const wordpressOrigins = [
  `${wpProtocol}://${wpHost}:${wpPort}`,
  `${wpProtocol}://localhost:${wpPort}`,
  `http://127.0.0.1:${wpPort}`,
  `http://localhost:${wpPort}`,
  `https://127.0.0.1:${wpPort}`,
  `https://localhost:${wpPort}`,
];

module.exports = defineConfig(async () => {
  const { default: tailwindcss } = await import("@tailwindcss/vite");

  return {
    plugins: [tailwindcss()],
    server: {
      host: "0.0.0.0",
      port: vitePort,
      strictPort: true,
      origin: `${viteProtocol}://${viteHost}:${vitePort}`,
      cors: {
        origin: wordpressOrigins,
        credentials: true,
      },
      hmr: {
        host: viteHost,
        port: vitePort,
        protocol: viteProtocol === "https" ? "wss" : "ws",
        clientPort: vitePort,
      },
    },
    build: {
      outDir: "assets/dist",
      emptyOutDir: true,
      manifest: true,
      rollupOptions: {
        input: path.resolve(__dirname, "assets/src/main.js"),
      },
    },
  };
});
