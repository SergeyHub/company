<template>
  <div class="row mt-3 content_page">
    <div class="col-md-12">
      <content-block slug="how-to-buy" />
    </div>
  </div>
</template>

<script>
  import ContentBlock from '~/components/ContentBlock'

  export default {
    components: {
      ContentBlock
    },
    // head() {
    //   return {
    //     title: this.$t('heading_seo.how_to_buy')
    //   }
    // }
  }
</script>
