<template>
  <div class="profile">
    <div class="page__wrap">
      <breadcrumbs :items="breadcrumbsLinks"/>
    </div>

    <anchors-block/>

    <no-ssr>
      <profile-head-block
        @showReviewModal="showReviewModal"
        @showMessageModal="showMessageModal"
      />
    </no-ssr>

    <section class="profile__section">
      <div class="container">
        <cost-block/>
      </div>
    </section>

    <section class="profile__section profile__contact">
      <div class="container">
        <contacts-block/>
      </div>
    </section>

    <section class="profile__info">
      <div class="container">
        <div class="profile__info-row">
          <personal-data-block/>
          <about-block/>
        </div>
      </div>
    </section>

    <section
      v-if="current_girl.videos.length > 0"
      id="video"
      class="profile__section profile__video"
    >
      <div class="container">
        <videos-block/>
      </div>
    </section>

    <section class="profile__gallery">
      <div class="container">
        <photos-block/>
      </div>
    </section>

    <section id="reviews" class="profile__section profile__reviews reviews">
      <div class="container">
        <reviews-block @showReviewModal="showReviewModal"/>
      </div>
    </section>

    <section id="other">
      <div class="container">
        <archive-block/>
      </div>
    </section>

    <ReviewModal ref="reviewModal"></ReviewModal>
    <MessageModal ref="messageModal"/>

    <Toolbar
      @showMessageModal="showMessageModal"
    />

    <!--<section class="profile__section">
      <div class="container">
        <GirlsArchive/>
      </div>
    </section>-->
    <!--
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
      <videos-block @buyAccess="openDialog" />
    </div>
    <div class="col-lg-6">
      <cost-block />
      <phone-block @buyAccess="openDialog" />
      <about-block/>
      <profile-site v-if="siteExist" />
      <personal-data-block/>
      <reviews-block/>
      <fake-block></fake-block>
    </div>-->
  </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import { Message } from 'element-ui'
    import Breadcrumbs from '~/components/Breadcrumbs'
    import Favourites from '~/components/Favourites'
    import ReviewsBlock from '~/components/GirlProfileBlocks/ReviewsBlock'
    import FakeBlock from '~/components/GirlProfileBlocks/FakeBlock'
    import PhoneBlock from '~/components/GirlProfileBlocks/PhoneBlock'
    import AboutBlock from '~/components/GirlProfileBlocks/AboutBlock'
    import PersonalDataBlock from '~/components/GirlProfileBlocks/PersonalDataBlock'
    import ProfileCover from "~/components/GirlProfileBlocks/ProfileCover";
    import PhotosBlock from "~/components/GirlProfileBlocks/PhotosBlock";
    import CostBlock from "~/components/GirlProfileBlocks/CostBlock";
    import AnchorsBlock from "~/components/GirlProfileBlocks/AnchorsBlock";
    import ProfileSite from '~/components/GirlProfileBlocks/ProfileSite'
    import VideosBlock from '~/components/GirlProfileBlocks/VideosBlock'
    import ProfileHeadBlock from '~/components/GirlProfileBlocks/ProfileHeadBlock'
    import ContactsBlock from '~/components/GirlProfileBlocks/ContactsBlock'
    import GirlsArchive from '~/components/GirlsArchive'
    import { declOfNum } from '~/utils'
    import ReviewModal from '~/components/ReviewModal'
    import MessageModal from '~/components/MessageModal'
    import Toolbar from '~/components/GirlProfileBlocks/Toolbar'
    import ArchiveBlock from "~/components/GirlProfileBlocks/ArchiveBlock";

    export default {
        components: {
            Breadcrumbs,
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
            Favourites,
            AnchorsBlock,
            ProfileHeadBlock,
            ContactsBlock,
            GirlsArchive,
            ReviewModal,
            ArchiveBlock,
            Toolbar,
            MessageModal
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
            },
            breadcrumbsLinks () {
              return [{
                text: this.current_girl.name
              }]
              /*
              let tmp = [];
              tmp.push({
                path: this.localePath('index'),
                text: this.$t('titles.home')
              });

              tmp.push({
                path: this.localePath({name: 'country', params: {country: this.current_girl.country.name}}),
                text: this.current_girl.country.name,
              });

              // city
              tmp.push({
                path: this.localePath({name: 'country-city', params: {country: this.current_girl.country.slug, city: this.current_girl.city.slug}}),
                text: this.current_girl.city.name
              });*/

              /*// girls
              tmp.push({
                path: this.localePath({name: 'country-city', params: {country: this.current_girl.country.slug, city: this.current_girl.city.slug}}),
                title: this.$t('titles.virgins')
              });*/

              tmp.push({
                text: this.current_girl.name
              });

              return tmp
            }
        },
        methods: {
            showMessageModal() {
              this.$refs.messageModal.open()
            },
            showReviewModal(){
                this.$refs.reviewModal.open()
            },
            openDialog() {
                if(this.current_girl.id < 37) {
                    Message.error(this.$t('other.test_profile'));
//                  return;
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
          if(!store.state.country || store.state.country.slug !== params.country) {
            try {
              await store.dispatch('fetchAndSetCountry', {
                slug: params.country,
                section: 'girls'
              });
            } catch (err) {
              return error({statusCode: 404, message: err.message})
            }
          }

          let current_city = store.state.city;

          if (!current_city || current_city.slug !== params.city) {
            try {
              await store.dispatch('setCurrentCity', params.city);
            } catch (err) {
              return error({statusCode: 404, message: err.message})
            }
          }

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
