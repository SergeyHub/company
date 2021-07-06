<template>
  <div>
    <Auth
      :currentMode="'login'"
      :previousPage="previousPage"
    />
    <!--<div class="auth-bottom">
      <router-link
        v-if="previousPage == null"
        :to="virginsPage"
        :title="$t('titles.home')"
        class="btn btn-border"
      >
        {{ $t('titles.home') }}
      </router-link>
      <router-link
        v-else
        :to="localePath(previousPage)"
        :title="$t('auth.back')"
        class="btn btn-border"
      >
        {{ $t('auth.back') }}
      </router-link>
    </div>-->
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
