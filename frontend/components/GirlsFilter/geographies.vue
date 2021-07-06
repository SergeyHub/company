<template>
  <div class="col-12">
    <div>{{$t('travels.ready_to_travel_to')}}</div>
    <div
      v-for="geography in geographies"
      :key="geography.slug"
      class="ready-to-travel-to"
      :class="{'current-geography': geography_global && geography_global.id===geography.id}"
    >
      <router-link
        :to="geographyLink(geography)"
        :title="geography.name"
      >
        {{ geography.name }}
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  components: {  },
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
  methods: {
    geographyLink(geography) {
      if(this.$route.params.country) {
        if(this.$route.params.city) {
          return this.localePath({name: 'country-city-travels-geography', params: {
              country: this.$route.params.country,
              city: this.$route.params.city,
              geography: geography.slug
            }})
        } else {
          return this.localePath({name: 'country-travels-geography', params: {country: this.$route.params.country, geography: geography.slug}})
        }
      }
      return this.localePath({name: 'travels-geography', params: {geography: geography.slug}})
    }
  }
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
