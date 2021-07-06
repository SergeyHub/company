<template>
  <div class="col-12 mb-3">
    <div>{{$t('travels.ready_to_travel_to')}}</div>
    <div v-for="geography in geographies" :key="geography.slug" class="ready-to-travel-to"  :class="{'current-geography': geography_global && geography_global.id===geography.id}">
      <router-link v-if="$route.params.country" :to="localePath({name: 'country-travels-geography', params: {country: $route.params.country, geography: geography.slug}})"
                   :title="geography.name">
        {{geography.name}}
      </router-link>
      <router-link v-else :to="localePath({name: 'travels-geography', params: {geography: geography.slug}})"
                   :title="geography.name">
        {{geography.name}}
      </router-link>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  //import BCollapse from "bootstrap-vue/src/components/collapse/collapse";
  //import BButton from "bootstrap-vue/src/components/button/button";
  import AppButton from '~/components/AppButton'

  export default {
    components: { AppButton },
    computed: {
      ...mapGetters(['geographies']),
      geography_global() {
        return this.$store.getters.geography;
      },
    },
    data() {
      return {
      }
    },
    async mounted() {
      if (!this.geographies)
        await this.$store.dispatch('setGeographies')
    },
  }
</script>
<style lang="scss">
  .ready-to-travel-to {
    margin-right: 14px;
    display: inline-block;
    a {
      color: #484949;
    }
  }
  .current-geography {
    font-weight: bold;
  }
</style>
