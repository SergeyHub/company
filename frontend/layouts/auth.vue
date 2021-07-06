<template>
  <div class="page__auth">
    <email-confirm-modal/>
    <div class="container">
      <div class="page__auth-wrap">
        <router-link :to="localePath('index')" class="auth__logo">
          <img :src="cdn_assets_prefix + '/files/icons/svg/logo.svg'" alt="">
        </router-link>
        <nuxt/>
      </div>
    </div>
  </div>
</template>
<script>
export default {
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
<style>

body {
  padding-top: 0 !important;
}

.page__auth {
  min-height: 100vh;
  height: 100%;
}
</style>
