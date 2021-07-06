<template>
  <div class="row mt-3 overflow-hidden">
    <div class="col-md-12 mb-3" v-if="isAdmin">
      <router-link :to="localePath({name: 'adminkas-mans-id', params: {id: current_girl.id}})">
        <b-button variant="primary" size="sm" class="float-right">
          <i class="fas fa-edit"></i> Редактировать
        </b-button>
      </router-link>
    </div>
    <favourites/>
    <div class="col-md-12 mb-3">
      <profile-cover @buyAccess="openDialog"/>
    </div>
    <div class="col-lg-6">
      <photos-block @buyAccess="openDialog" />
      <videos-block
        v-if="current_girl.videos.length > 0"
        @buyAccess="openDialog"
      />
    </div>
    <div class="col-lg-6">
      <cost-block />
      <phone-block @buyAccess="openDialog" />
      <about-block/>
      <profile-site v-if="siteExist" />
      <personal-data-block/>
      <reviews-block/>
      <fake-block></fake-block>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import { Message } from 'element-ui'
  import Favourites from '~/components/Favourites'
  import ReviewsBlock from '~/components/GirlProfileBlocks/ReviewsBlock'
  import FakeBlock from '~/components/GirlProfileBlocks/FakeBlock'
  import PhoneBlock from '~/components/GirlProfileBlocks/PhoneBlock'
  import AboutBlock from '~/components/GirlProfileBlocks/AboutBlock'
  import PersonalDataBlock from '~/components/GirlProfileBlocks/PersonalDataBlock'
  import ProfileCover from "../../components/GirlProfileBlocks/ProfileCover";
  import PhotosBlock from "../../components/GirlProfileBlocks/PhotosBlock";
  import CostBlock from "../../components/GirlProfileBlocks/CostBlock";
  import ProfileSite from '~/components/GirlProfileBlocks/ProfileSite'
  import VideosBlock from '~/components/GirlProfileBlocks/VideosBlock'
  import { declOfNum } from '~/utils'

  export default {
    components: {
      ProfileCover,
      ReviewsBlock,
      FakeBlock,
      PhoneBlock,
      AboutBlock,
      PersonalDataBlock,
      PhotosBlock,
      VideosBlock,
      CostBlock,
      ProfileSite,
      Favourites
    },
    head() {
      const age = this.current_girl.age;

      let title = this.$t('titles.girl')
        .replace(/%country_prepositional%/gi, (this.current_girl.country && this.current_girl.country.id ? (this.current_girl.country.name_prepositional ? this.current_girl.country.name_prepositional : this.current_girl.country.name) : ''))
        .replace(/%country_genitive%/gi, (this.current_girl.city && this.current_girl.city.id ? (this.current_girl.country.name_genitive ? this.current_girl.country.name_genitive : this.current_girl.city.name) : ''))
        .replace(/%country_instrumental%/gi, (this.current_girl.country && this.current_girl.country.id ? (this.current_girl.country.name_instrumental ? this.current_girl.country.name_instrumental : this.current_girl.country.name) : ''))
        .replace(/%country_dative%/gi, (this.current_girl.country && this.current_girl.country.id ? (this.current_girl.country.name_dative ? this.current_girl.country.name_dative : this.current_girl.country.name) : ''))
        .replace(/%country_accusative%/gi, (this.current_girl.country && this.current_girl.country.id ? (this.current_girl.country.name_accusative ? this.current_girl.country.name_accusative : this.current_girl.country.name) : ''))
        .replace(/%city_prepositional%/gi, (this.current_girl.city && this.current_girl.city.id ? (this.current_girl.city.name_prepositional ? this.current_girl.city.name_prepositional : this.current_girl.city.name) : ''))
        .replace(/%city_genitive%/gi, (this.current_girl.city && this.current_girl.city.id ? (this.current_girl.city.name_genitive ? this.current_girl.city.name_genitive : this.current_girl.city.name) : ''))
        .replace(/%city_instrumental%/gi, (this.current_girl.city && this.current_girl.city.id ? (this.current_girl.city.name_instrumental ? this.current_girl.city.name_instrumental : this.current_girl.city.name) : ''))
        .replace(/%city_dative%/gi, (this.current_girl.city && this.current_girl.city.id ? (this.current_girl.city.name_dative ? this.current_girl.city.name_dative : this.current_girl.city.name) : ''))
        .replace(/%city_accusative%/gi, (this.current_girl.city && this.current_girl.city.id ? (this.current_girl.city.name_accusative ? this.current_girl.city.name_accusative : this.current_girl.city.name) : ''))
        .replace(/%country%/gi, (this.current_girl.country && this.current_girl.country.id ? this.current_girl.country.name : ''))
        .replace(/%city%/gi, (this.current_girl.city && this.current_girl.city.id ? this.current_girl.city.name : ''))
        .replace(/%name%/gi, this.current_girl.name)
        .replace(/%age%/gi, this.current_girl.age)
        .replace(/%ru_age%/gi, age + ' ' + declOfNum(age, ['год', 'года', 'лет']))
        .replace(/%cost%/gi, this.current_girl.cost ? ' ' + this.current_girl.cost + '$' : '');

      return {
        title: title,
        meta: [
          {name: 'og:title', content: title},
          {name: 'og:image', content: this.current_girl.avatar}
        ]
      }
    },
    data() {
      return {
        loading: true,
        index: null,
        avatar: null,
        bill: {},
      }
    },
    watch: {
      index(newVal, prevVal) {
        this.avatar = this.photos[newVal ? newVal : prevVal]
      },
      photos: {
        deep: true,
        immediate: true,
        handler(newVal, prevVal) {
          this.avatar = newVal[0]
        }
      }
    },
    computed: {
      ...mapGetters('auth', ['isAuthentificated', 'isAdmin', 'loggedUser']),
      ...mapGetters('girls', ['current_girl']),
      photos() {
        if(this.current_girl && this.current_girl.photos)
          return [this.current_girl.avatar, ...this.current_girl.photos];
        return [];
      },
      siteExist() {
        return this.current_girl.profile_site;
      }
    },
    methods: {
      openDialog() {
        if(this.current_girl.id < 37) {
          Message.error(this.$t('other.test_profile'));
//          return;
        }
        let successAuth = () => {
          let dialog = {
            id: 'tmp_dialog_with_' + this.current_girl.user_id,
            lastMessage: null,
            userFirst: {
              id: this.loggedUser.id,
              type: 'client',
            },
            userSecond: {
              id: this.current_girl.user_id,
              name: this.current_girl.name,
              avatar: this.current_girl.avatar,
              type: 'girl',
              girl_id: this.current_girl.id
            }
          };
          // добавляем фейковый диалог
          this.$store.dispatch('chat/prependDialog', dialog)
          // пробуем открыть этот диалог
          this.$chat.open({ user_id: this.current_girl.user_id })
        };

        if(!this.isAuthentificated) {
          this.$loginModal.open({
            mode: 'register',
            user_type: 'client',
            afterRegistration: successAuth,
            afterLogin: successAuth,
          });
          return;
        } else {
          successAuth();
        }
      },

      buyAccess() {
        let successAuth = () => {
          this.loading = true;
          this.$store.dispatch('girls/buyAccessToGirl', this.current_girl.id)
            .then((response) => {
              this.loading = false;
              this.bill = response;
              this.$ga.event('client', 'try_buy_girl');
              this.$paymentModal.open({
                title: this.$t('payments.buy_girl_phone_title'),
                bill: this.bill,
              })
            })
            .catch((error) => {
              this.loading = false;
            })
        };

        if(!this.isAuthentificated) {
          this.$loginModal.open({
            mode: 'register',
            user_type: 'client',
            afterRegistration: successAuth,
            afterLogin: successAuth,
          });
          return;
        } else {
          successAuth();
        }
      }
    },
    async asyncData({ store, params, error }) {
      try {
        await store.dispatch('girls/fetchGirl', params.id)
      } catch (e) {
        error({ statusCode: 404, message: e.message })
      }
    },
    beforeRouteLeave (to, from, next) {
        if(!to.params.city)
            this.$store.dispatch('resetCity');
        if(!to.params.country)
            this.$store.dispatch('resetCountry');
        next();
    }
  }
</script>
