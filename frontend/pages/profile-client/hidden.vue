<template>
  <div>
    <div class="container pt-30 pb-30">
      <girls-archive
        :girls="hidden"
        :showLoadMoreButton="false"
        :showSidebar="false"
        :showRemoveButton="true"
        @remove="removeFromHidden"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import GirlsArchive from '~/components/GirlsArchive'
import { Message } from 'element-ui'

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
    ...mapGetters('girls', ['hidden'])
  },

  async asyncData({ store }) {
    return store.dispatch('girls/fetchHidden').then(() => ({

    }))
  },

  methods: {
    removeFromHidden(model) {
      this.$store.dispatch('girls/removeFromHidden', model.id)
        .then(result => {
          if(result.success) {
            Message.success(this.$t('public_profile.removedFromHidden'))
          }
        })
    }
  }
}
</script>
