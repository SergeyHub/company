<template>
  <div class="profile-cover">
    <!--Cover image-->
    <img v-lazy="coverPhoto" itemprop="image" :alt="current_girl.name + ' ' + $t('titles.virgin')">
    <div class="image-shader"></div>

    <div class="header-title-wrapper">
      <router-link v-if="current_girl.prev_girl" :to="getGirlLink(current_girl.prev_girl)" class="prev-girl">
       <i class="fa fa-angle-left"></i>
      </router-link>
      <div>
        <h1 class="header-title girl-profile-title">
          <span itemprop="name">{{ current_girl.name }}</span>
          <span class="add-to-favourites" @click="addToFavourites" :class="isFavourite ? 'is-favourite' : ''">
           <i class="fas fa-heart"></i>
           <i class="fa fa-times"></i>
          </span>
        </h1>
      </div>
      <div class="details">
        {{ $t('public_profile.views') }} {{ current_girl.views }}
        <template v-if="current_girl.created_at">
          • {{ $t('public_profile.since') }} {{ current_girl.created_at }}
        </template>
      </div>
      <router-link v-if="current_girl.next_girl" :to="getGirlLink(current_girl.next_girl)" class="next-girl">
        <i class="fa fa-angle-right"></i>
      </router-link>
    </div>
  </div>
</template>

<script>
  import Accordion from '~/components/Accordion'
  import Breadcrumbs from '~/components/Breadcrumbs'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      Accordion,
      Breadcrumbs
    },
    computed: {
      ...mapGetters(['country']),
      ...mapGetters('girls', ['current_girl', 'favourites']),
      ...mapGetters('auth', ['loggedUser', 'isAuthentificated']),
      isFavourite() {
        return this.favourites.findIndex(el => el.id == this.current_girl.id) > -1;
      },
      coverPhoto() {
        if(!this.current_girl.photos.length)
          return null;
        return _.sample(this.current_girl.photos).big;
      }
    },
    methods: {
      addToFavourites(){
        if(!this.isAuthentificated) {
          this.$loginModal.open({
            mode: 'login',
          });
          return;
        } else {
          if (!this.isFavourite) {
            this.$store.dispatch('girls/addToFavourites', this.$route.params.id)
          } else {
            this.$store.dispatch('girls/removeFromFavourites', this.$route.params.id)
          }
        }
      },
      getGirlLink(girl) {
        let name = 'country-city-mans-id'

        let link = this.localePath({
          name: name,
          params: {
            id: girl.id,
            country: girl.country.slug,
            city: girl.city.slug
          }
        })
        return link
      }
    }
  }
</script>
