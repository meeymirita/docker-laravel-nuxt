// nuxt.config.ts
export default defineNuxtConfig({
    css: [
        '~/assets/styles/main.scss'
    ],

    compatibilityDate: '2025-07-15',
    devtools: { enabled: true },
    modules: ['@nuxt/icon'],


    server: {
        host: '0.0.0.0',
        port: 3000
    }
})
