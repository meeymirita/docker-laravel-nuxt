export default defineNuxtConfig({
    css: ['~/assets/styles/main.scss'],

    devServer: {
        host: '0.0.0.0',          // слушать на всех интерфейсах
        port: 3000,
        allowedHosts: ['meeymirita.ru', 'localhost', '0.0.0.0']
    },

    nitro: { preset: 'node-server', serveStatic: true },

    vite: {
        server: {
            host: true,
            allowedHosts: ['meeymirita.ru', 'localhost', '0.0.0.0']
        }
    }
})
