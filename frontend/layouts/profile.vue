<template>
  <div>
    <!--<login-modal/>-->
    <header-view/>
    <profile-nav/>
    <nuxt/>


    <footer-view/>
    <chat-fullscreen/>
    <chat-button/>

    <country-modal/>
    <city-modal/>
    <search-modal/>
  </div>
</template>

<script>
  import FooterView from '~/components/FooterView'
  import HeaderView from '~/components/HeaderView.vue'
  import ProfileNav from '~/components/ProfileNav'
  import ChatButton from '~/components/ChatFullscreen/components/ChatButton'

  export default {
    middleware: 'authentificated',
    components: {
      HeaderView,
      ProfileNav,
      FooterView,
      ChatButton
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
