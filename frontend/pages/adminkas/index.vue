<template>
  <div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    layout: 'admin',
    beforeRouteEnter(from, to, next) {
      next('/adminkas/applications')
    }
  }
</script>
