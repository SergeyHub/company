<template>
  <div>
    <girl-nav/>
    <girl-profile :init-data="form" />
  </div>
</template>

<script>
  import Breadcrumbs from '~/components/Breadcrumbs'
  import GirlProfile from '~/components/GirlProfile'
  import GirlNav from '~/components/GirlNav'

  export default {
    layout: 'profile',

    components: {
      GirlProfile,
      Breadcrumbs,
      GirlNav
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
