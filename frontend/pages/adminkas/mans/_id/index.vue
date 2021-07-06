<template>
  <div>
    <admin-girl-nav/>
    <girl-profile :init-data="form" />
  </div>
</template>

<script>
import Breadcrumbs from '~/components/Breadcrumbs'
import GirlProfile from '~/components/GirlProfile'
import AdminGirlNav from '~/components/AdminGirlNav'

export default {
  layout: 'admin',

  components: {
    GirlProfile,
    Breadcrumbs,
    AdminGirlNav
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
