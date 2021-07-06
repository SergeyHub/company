<template>
  <div>
    <agency-profile :initData="form"/>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import AgencyProfile from '~/components/AgencyProfile'

  export default {
    layout: 'profile',
    middleware: 'is_agency',

    components: {
      AgencyProfile
    },

    computed: {
      ...mapGetters('profile', ['agency_profile'])
    },

    // head() {
    //   return {
    //     title: this.$t('profile.title')
    //   }
    // },

    async asyncData({ store }) {
      return store.dispatch('profile/fetchAgencyProfile')
        .then((data) => {
          return {
            form: _.cloneDeep(data)
          }
        })
    }
  }
</script>
