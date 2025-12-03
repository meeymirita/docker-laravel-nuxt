// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    css: [
        '~/assets/styles/main.scss'
    ],

    // ДЛЯ NUXT 4
    nitro: {
        preset: 'node-server',
        serveStatic: true,

        // Хосты и порт
        serverAssets: [
            {
                baseName: 'public',
                dir: './public'
            }
        ]
    },

    // Dev сервер
    devServer: {
        host: '0.0.0.0',
        port: 3000
    },

    // Рантайм конфиг
    runtimeConfig: {
        public: {
            siteUrl: process.env.NUXT_PUBLIC_SITE_URL || 'http://meeymirita.ru'
        }
    },

    compatibilityDate: '2025-07-15',
    devtools: { enabled: true },
    modules: ['@nuxt/icon']
})