<template>
  <div class="row" style="position: relative">
    <div class="col-md-12 mb-3">
      <div class="Typography_h2">{{ $t('profile_client.girls_title') }}</div>
    </div>
    <div class="col-md-3" v-for="(girl, index) in girls" :key="index">
      <model-block :model="girl" />
    </div>
    <div class="col-md-12" v-if="!girls.length">
      {{ $t('profile_client.not_buyed_girls') }}
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import ModelBlock from '~/components/ModelBlock'

  export default {
    layout: 'profile',
    middleware: 'is_client',

    components: {
      ModelBlock
    },
    //
    // head() {
    //   return {
    //     title: this.$t('profile_client.girls_title')
    //   }
    // },

    computed: {
      ...mapGetters('profile', ['client_profile'])
    },

    async asyncData({ store }) {
      return store.dispatch('profile/fetchClientGirls')
        .then((data) => {
          return {
            girls: data
          }
        })
    },
  }
</script>
