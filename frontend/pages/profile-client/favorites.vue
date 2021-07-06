<template>
  <div>
    <div class="container pt-30 pb-30">
      <girls-archive
        :girls="favourites"
        :showLoadMoreButton="false"
        :showSidebar="false"
        :showRemoveButton="true"
        @remove="removeFromFavourites"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import GirlsArchive from '~/components/GirlsArchive'

export default {
  layout: 'profile',
  middleware: 'is_client',

  components: {
    GirlsArchive
  },

  head() {
    return {
      title: this.$t('profile_client.girls_title')
    }
  },

  computed: {
    ...mapGetters('auth', ['isAuthentificated']),
    ...mapGetters('girls', ['favourites'])
  },

  async asyncData({ store }) {
    return store.dispatch('girls/fetchFavourites').then(() => ({

    }))
  },

  methods: {
    removeFromFavourites(model) {
      this.$store.dispatch('girls/removeFromFavourites', model.id)
    }
  }
}
</script>
