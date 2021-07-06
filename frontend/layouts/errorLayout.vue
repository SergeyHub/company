<template>
  <div>
    <header-view/>
    <nuxt class="content"/>

    <footer-view class="footer" :showSeo="false"/>

    <country-modal/>
    <city-modal/>
    <search-modal/>
  </div>
</template>
<script>
  import FooterView from '~/components/FooterView'
  import HeaderView from '~/components/HeaderView.vue'

  export default {
    components: {
      FooterView,
      HeaderView
    }
  }
</script>
