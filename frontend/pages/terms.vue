<template>
  <div class="row mt-3 content_page">
    <div class="col-md-12">
      <content-block slug="terms" />
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
    //     title: this.$t('titles.terms')
    //   }
    // }
  }
</script>
