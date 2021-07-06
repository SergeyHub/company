<template>
  <div :class="{unclickable:profileOnInspection}">
    <media/>
  </div>
</template>

<script>
  import Media from '~/components/GirlProfile/media'
  import { mapGetters } from 'vuex'

  export default {
    layout: 'profile',
    middleware: 'is_girl',

    components: {
      Media,
    },

    computed: {
      ...mapGetters('profile', ['profileOnVerify', 'profileOnInspection'])
    },

    // head() {
    //   return {
    //     title: this.$t('profile_nav.photos')
    //   }
    // },

    async fetch({ store }) {
      await store.dispatch('profile/fetchIndependentProfile')
    }
  }
</script>
