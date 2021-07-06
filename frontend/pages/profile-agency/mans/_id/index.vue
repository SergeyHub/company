<template>
  <div>
    <agency-girl-nav/>
    <girl-profile :init-data="form" />
  </div>
</template>

<script>
  import GirlProfile from '~/components/GirlProfile'
  import AgencyGirlNav from '~/components/AgencyGirlNav'

  export default {
    layout: 'profile',

    components: {
      GirlProfile,
      AgencyGirlNav
    },

    async asyncData({ store, params }) {
      return store.dispatch('girls/fetchEditGirl', params.id)
        .then((data) => {
          if(data.country) {
            return store.dispatch('getCitiesForCountry', data.country)
              .then(() => {
                return {
                  form: _.cloneDeep(data)
                }
              })
              .catch(() => {
                return {
                  form: _.cloneDeep(data)
                }
              })
          }
          return {
            form: _.cloneDeep(data)
          }
        })
    }

  }
</script>
