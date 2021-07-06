<template>
  <div>
    <admin-girl-nav/>
    <media/>
  </div>
</template>

<script>
import Media from '~/components/GirlProfile/media'
import AdminGirlNav from '~/components/GirlNav'

export default {
  layout: 'admin',

  components: {
    AdminGirlNav,
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
