<template>
  <div>
    <girl-nav/>
    <media/>
  </div>
</template>

<script>
  import Media from '~/components/GirlProfile/media'
  import GirlNav from '~/components/GirlNav'

  export default {
    layout: 'profile',
    middleware: 'is_girl',

    components: {
      GirlNav,
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
