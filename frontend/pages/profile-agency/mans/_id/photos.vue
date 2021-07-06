<template>
  <div>
    <agency-girl-nav/>
    <media />
  </div>
</template>

<script>
  import Media from '~/components/GirlProfile/media'
  import AgencyGirlNav from '~/components/AgencyGirlNav'

  export default {
    layout: 'profile',
    middleware: 'is_agency',

    components: {
      AgencyGirlNav,
      Media
    },

    async asyncData({ store, params }) {
      return store.dispatch('girls/fetchEditGirl', params.id)
        .then((data) => {
          return {
            form: _.cloneDeep(data)
          }
        })
    }

  }
</script>
