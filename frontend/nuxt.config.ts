// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    app: {
        head: {
            link: [
                // Подключение Google Fonts
                { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
                { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' },
                {
                    rel: 'stylesheet',
                    href: 'https://fonts.googleapis.com/css2?family=Bitcount+Grid+Single:wght@100..900&family=Turret+Road:wght@200;300;400;500;700;800&display=swap'
                }
            ]
        }
    },
    css: [
        './app/assets/styles/main.css'
    ],
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true }
})
