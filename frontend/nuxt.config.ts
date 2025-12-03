export default defineNuxtConfig({
    css: ['~/assets/styles/main.scss'],

    nitro: {
        preset: 'node-server',
        serveStatic: true,
        serverAssets: [
            { baseName: 'public', dir: './public' }
        ]
    },

    devServer: {
        host: '0.0.0.0',
        port: 3000,
        allowedHosts: ['meeymirita.ru', 'localhost'] // <--- разрешаем твой домен
    },

    runtimeConfig: {
        public: {
            siteUrl: process.env.NUXT_PUBLIC_SITE_URL || 'http://meeymirita.ru'
        }
    },

    compatibilityDate: '2025-07-15',
    devtools: { enabled: true },
    modules: ['@nuxt/icon'],

    vite: {
        server: {
            host: true,
            allowedHosts: ['meeymirita.ru', 'localhost'] // <--- тоже нужно для Vite
        }
    }
})
