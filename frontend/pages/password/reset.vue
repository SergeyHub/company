<template>
  <div v-show="ready">
    <Auth :currentMode="mode"/>
    <div class="page__auth-form-field-item text-center">
      <router-link
        v-if="previousPage == null"
        :to="virginsPage"
        :title="$t('titles.home')"
        class="btn btn-text btn-backpage"
      >
        {{ $t('titles.home') }}
      </router-link>
      <router-link
        v-else
        :to="localePath(previousPage)"
        :title="$t('auth.back')"
        class="btn btn-text btn-backpage"
      >
        {{ $t('auth.back') }}
      </router-link>
    </div>
  </div>
</template>
<script>
import Auth from '~/components/Auth'
import { Message } from 'element-ui'
import { mapGetters } from 'vuex'

export default {
  layout: 'auth',
  components: {
    Auth
  },
  data() {
    return {
      previousPage: null,
      ready: false,
      mode: 'reset_password_request'
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
    ...mapGetters('auth', ['loggedUser']),

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
  },
  created() {

    if(process.client && this.$route.query.email && this.$route.query.token) {
      this.authByResetToken()
    } else {
      this.ready = true
    }
  },
  /**asyncData({store, query, redirect, app}) {
      if(query.email && query.token) {
        const params = {
          resetToken: query.token,
          email: query.email
        }

        return store.dispatch('auth/authByResetToken', params)
          .then((response) => {
            let link = 'profile-settings'
            if(store.getters['auth/loggedUser'].type == 'client') {
              link = app.localePath('profile-client-settings')
            } else if(store.getters['auth/loggedUser'].type == 'agency') {
              link = this.localePath('profile-agency-settings')
            }
            //console.log(link)
            redirect({path: link})
            return {mode: 'reset_password_request'}
          })
        .catch((err) => {
          return {mode: 'reset_password_request'}
        })
      }
    },**/
  methods: {
    authByResetToken: _.throttle(function(){

      const params = {
        resetToken: this.$route.query.token,
        email: this.$route.query.email
      }


      this.$store.dispatch('auth/authByResetToken', params)
        .then((response) => {
          let link = this.localePath('profile-settings')
          if(this.loggedUser.type == 'client') {
            link = this.localePath('profile-client-settings')
          } else if(this.loggedUser.type == 'agency') {
            link = this.localePath('profile-agency-settings')
          }
          this.$router.replace({path: link})
        })
        .catch((err) => {
          Message.error(err.response.data.message)
          this.ready = true
        })
    }, 100000)
  }
}
</script>
