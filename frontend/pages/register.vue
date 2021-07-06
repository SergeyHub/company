
<template>
  <div>
    <Auth
      :currentMode="'register'"
      :previousPage="previousPage"
    />
  </div>
</template>
<script>
import Auth from '~/components/Auth'

export default {
  layout: 'auth',
  components: {
    Auth
  },
  data() {
    return {
      previousPage: null
    }
  },
  beforeRouteEnter(to,from,next, c) {
    next(vm => {
      if(from.fullPath !== '/' && from.fullPath.search(/(register)|(login)/g) == -1) {
        vm.previousPage = from
      }
    })
  },
  computed: {
    virginsPage() {
      if(this.$route.params.country) {
        if(this.$route.params.city) {
          return this.localePath({name: 'country-city', params: {country: this.$route.params.country, city: this.$route.params.city}})
        } else {
          return this.localePath({name: 'country', params: {country: this.$route.params.country}})
        }
      }
      return this.localePath('index');
    },
  }
}
</script>
