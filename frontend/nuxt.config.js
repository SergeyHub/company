import webpack from 'webpack'

let cdn_domain = 'https://static.mybestgigolo.com';
import { version } from './version.json'

module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    title: 'MyBestGigolo',
    titleTemplate: '%s - MyBestGigolo',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' },
      { name: 'og:image', content: 'https://static.mybestgigolo.com/assets/img/logo.png'}
    ],
    link: [
      { rel: 'icon ', type: 'image/x-icon', href: cdn_domain + '/favicon.ico' },
      { rel: 'stylesheet', href: cdn_domain + '/assets/ilightbox/css/ilightbox.css' }
    ],
    script: [
      { src: cdn_domain + '/assets/js/jquery-1.11.1.min.js' },
      { src: cdn_domain + '/assets/ilightbox/js/jquery.requestAnimationFrame.js' },
      { src: cdn_domain + '/assets/ilightbox/js/jquery.mousewheel.js' }
    ],
  },
  modules: [
    //'bootstrap-vue/nuxt',
    'cookie-universal-nuxt',
    ['@nuxtjs/axios'],
    ['@nuxtjs/dayjs'],
    ['@nuxtjs/robots', {
      robots: {
        UserAgent: '*',
        Disallow: '/'
      }
    }],
    ['nuxt-i18n', {
      locales: [
        { code: 'en', iso: 'en-US', file: 'en.js', name: 'English', image: '/img/en.png' },
        { code: 'ru', iso: 'ru-RU', file: 'ru.js', name: 'Русский', image: '/img/ru.png' }
      ],
      lazy: true,
      langDir: 'locales/',
      defaultLocale: 'en',
      vueI18n: {
        fallbackLocale: 'ru',
      },
      parsePages: true,
      detectBrowserLanguage: false
    }],
    ['@nuxtjs/google-analytics', {
      id: 'UA-59445954-25'
    }],
    ['@nuxtjs/recaptcha', {
      siteKey: process.env.production === 'true' ? '6LeiLOoUAAAAABOJON1PdJZQcQ8F_m_YY0kHzREF' : '6LcnxaEUAAAAAIOleQZSJFGMlxjjNsJcM9a1HaPc',
      version: 2,
    }],
    '@nuxtjs/sentry',
    [
      '@nuxtjs/yandex-metrika',
      {
        id: '62104240',
        webvisor: true,
        clickmap:true,
        accurateTrackBounce: true,
        trackLinks: true
      }
    ]
  ],
  sentry: {
    dsn: 'https://faf42e920dd8472ba695ad5b2bcc17f4@sentry.io/2459260',
    config: {},
  },
  plugins: [
    '~/plugins/assets',
    '~/plugins/axios',
    '~/plugins/i18n',
    '~/plugins/vee-validate',
    '~/plugins/placeholders',
    '~/plugins/login-modal',
    '~/plugins/email-confirm-modal',
    '~/plugins/country-modal',
    '~/plugins/search-modal',
    '~/plugins/chat',
    {src: '~/plugins/intercom', ssr: true},
    {src: '~/plugins/datepicker', ssr: false},
    {src: '~/plugins/select', ssr: false},
    {src: '~/plugins/dropzone', ssr: false},
    {src: '~/plugins/toast', ssr: false},
    {src: '~/plugins/sliders', ssr: false },
    {src: '~/plugins/shards', ssr: false},
    {src: '~/plugins/cropper', ssr: false},
    {src: '~/plugins/elementui', ssr: false},
    {src: '~/plugins/socketinit', ssr: false},
    {src: '~/plugins/infinite-scroll', ssr: false},
    {src: '~/plugins/image-editor', ssr: false},
    { src: '~/plugins/nuxt-quill-plugin.js', ssr: false },
    { src: '~/plugins/lazyload.js', ssr: false },
    { src: '~/plugins/swiper.js', ssr: false },
    { src: '~/plugins/lightgallery.js', ssr: false },
    { src: '~/plugins/tooltip.js', ssr: false }
  ],
  css: [
    'node_modules/@fortawesome/fontawesome-free/css/all.css',
    //'~/assets/css/style.css',
    //'~/assets/css/fonts.css',
    //'~/assets/css/media.css',
    'quill/dist/quill.snow.css',
    'quill/dist/quill.bubble.css',
    'quill/dist/quill.core.css',
    '~/assets/scss/app.scss'
  ],
  layoutTransition: {
    name: 'page',
    mode: 'out-in'
  },
  /*
  ** Customize the progress bar color
  */
  loading: { color: '#3B8070' },
  buildDir: __dirname + '/releases/' + version,
  /*
  ** Build configuration
  */
  build: {
    /*
    ** Run ESLint on save
    */
    extend (config, { isDev, isClient }) {
      if (isDev && isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    },
    publicPath: cdn_domain + '/static/',
    extractCSS: {
      allChunks: true
    },
    plugins: [
      new webpack.ProvidePlugin({
        '_': 'lodash'
      })
    ]
  },
  env: {
    appName: 'Gigolo',
    production: process.env.production === 'true',
    base_domain: process.env.production === 'true' ? 'dev.mybestgigolo.com' : 'zhigalo.test',
    cdn_domain: process.env.production === 'true' ? cdn_domain : '',
    cdn_assets: process.env.production === 'true' ? cdn_domain + '/assets' : '',
    intercom_app_id: 'lln69rjo'
  }
}
