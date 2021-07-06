<template>
  <div>
    <header-view/>
    <admin-nav/>

    <nuxt/>

    <footer-view/>

    <country-modal/>
    <city-modal/>
    <search-modal/>
  </div>
</template>

<script>
  import FooterView from '~/components/FooterView'
  import HeaderView from '~/components/HeaderView.vue'
  import AdminNav from '~/components/AdminNav'
  import VipAd from '~/components/VipAd'

  export default {
    middleware: 'is_admin',
    components: {
      HeaderView,
      AdminNav,
      VipAd,
      FooterView
    },
    head() {
      let canonical = 'https://' + process.env.base_domain + (this.$route.path === '/' ? '' : this.$route.path.replace(/\/*$/, '/') )
      return {
        link: [
          { rel: 'canonical', href: canonical }
        ]
      }
    }
  }
</script>
