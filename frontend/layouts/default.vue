<template>
  <div>
    <header-view/>
    <nuxt class="content"/>

    <footer-view class="footer"/>

    <eighteen-banner v-if="show_eighteen_banner" />
    <country-modal/>
    <city-modal/>
    <search-modal/>
    <!--<chat-fullscreen v-if="isAuthentificated"/>
    <chat-button/>-->
    <support-widget/>
  </div>
</template>

<script>
  import FooterView from '~/components/FooterView'
  import HeaderView from '~/components/HeaderView.vue'
  import EighteenBanner from '~/components/EighteenBanner'
  import Cookie from 'js-cookie'
  import SupportWidget from '~/components/SupportWidget'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      HeaderView,
      FooterView,
      EighteenBanner,
      SupportWidget
    },
    computed: {
      ...mapGetters('auth', ['isAuthentificated'])
    },
    data() {
      return {
        show_eighteen_banner: false
      }
    },
    mounted() {
      if(!Cookie.get('18_showed')) {
        this.show_eighteen_banner = true;
      }
    },
    head() {
      let canonical = 'https://' + process.env.base_domain + (this.$route.path === '/' ? '' : this.$route.path.replace(/\/*$/, '/') )
      return {
        link: [
          { rel: 'canonical', href: canonical }
        ]
      }
    },
  }
</script>

