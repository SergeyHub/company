<template>
    <div class="heading-favourites col-12">
      <div v-for="(favourite, index) in favourites" :key="index" class="favourite-item mb-3">
        <div @click="removeFromFavourites(favourite.id)" class="remove-favourite">
          <i class="fa fa-times"></i>
        </div>
        <router-link :to="localePath({name: 'mans-id', params: {id: favourite.id}})" :id="'favourite-girl-'+favourite.id">
          <div class="favourite-avatar" v-lazy:background-image="favourite.avatar" />
          <b-tooltip class="favourite-tooltip" :target="'favourite-girl-'+favourite.id" style="display:none;" triggers="hover">
            <b>{{favourite.name}}</b> {{$t('other.from')}} {{favourite.country_name}}, {{favourite.city}}
          </b-tooltip>
        </router-link>
      </div>
    </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    components: {},
    computed: {
      ...mapGetters('auth', ['isAuthentificated']),
      ...mapGetters('girls', ['favourites']),
    },
    mounted() {
      if(this.isAuthentificated)
        this.$store.dispatch('girls/fetchFavourites')
    },
    methods: {
      removeFromFavourites(id) {
        this.$store.dispatch('girls/removeFromFavourites', id)
      }
    }
  }
</script>
