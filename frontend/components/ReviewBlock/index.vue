<template>
  <div class="reviews__item">
    <div class="reviews__item-avatar">
      <router-link :to="generateLink(model.girl)" :title="getGirlTitle(model.girl)">
        <img v-lazy="model.girl.avatar" :alt="getGirlAlt(model.girl)">
        <div class="reviews__item-avatar-title">
          {{ model.girl.name }}
        </div>
      </router-link>
    </div>
    <div class="reviews__item-desc">
      <div class="reviews__item-meta">
        <div class="reviews__item-meta-data">{{ model.meeting_date }}</div>
        <!--<div class="reviews__item-meta-stars">
          <ul>
            <li class="on"></li>
            <li class="on"></li>
            <li class="on"></li>
            <li class="on"></li>
            <li class="on"></li>
          </ul>
        </div>-->
      </div>
      <div class="reviews__item-meta">
        <div class="reviews__item-meta-year">{{ model.nickname }}</div>
        <div class="reviews__item-meta-city">{{ model.girl.country_name }}, {{ model.girl.city }}</div>
        <router-link
          class="reviews__item-meta-profile"
          :to="generateLink(model.girl)"
          :title="getGirlTitle(model.girl)"
        >
          {{ $t('reviews.open_profile') }}
        </router-link>
      </div>
      <div class="reviews__item-content">
        <div class="reviews__item-content-wrap">
          <div class="reviews__item-content-user">
            <!--<img :src="cdn_assets_prefix + '/assets/images/archive/reviews/avatar.jpg'" alt="">-->
            <!--<div class="reviews__item-content-user-name">{{ model.nickname }}</div>-->
          </div>
          <div class="reviews__item-content-user-review">
            {{model.review}}
          </div>
        </div>
      </div>
    </div>
  </div>
    <!--<d-card class="review-block">
      <i class="document_verified_icon fas fa-check-circle" v-if="model.verified==='yes'"></i>
      <div class="review-head">
      <router-link :to="localePath({name: 'mans-id', params: {id: model.girl.id}})">
        <div class="review-avatar" v-lazy:background-image="model.girl.avatar"/>
      </router-link>
      <div class="review-item-info">
        <h3>{{ model.girl.name}}</h3>
        <div><span class="font-weight-bold">{{$t('public_profile.meeting_date')}}:</span> {{model.meeting_date}}</div>
        <div><span class="font-weight-bold">{{$t('public_profile.meeting_city')}} / {{$t('public_profile.meeting_country')}}:</span> {{model.meeting_city}} {{model.meeting_country}}</div>
        <div><span class="font-weight-bold">{{$t('public_profile.price')}}, {{$t('public_profile.duration')}}:</span> {{model.price}} {{model.currency}}, {{model.duration}} {{$t('public_profile.'+model.duration_type)}}</div>
      </div>
      </div>
      <div class="font-weight-bold mt-2">
         {{model.nickname}}'s review,
      </div>
          <div class="mb-2 mt-1">
            {{model.review}}
          </div>

      <router-link :to="localePath({name: 'mans-id', params: {id: model.girl.id}})">
        <div class="badge badge-reviews">{{$t('reviews.reviews')}}: {{model.girl.reviews_count}}</div>
      </router-link>
    </d-card>-->
</template>

<script>
    export default {
        props: {
            model: {
                type: Object,
                default: () => {}
            },
            showInfo: {
              type: Boolean,
              default: () => true
            }
        },
      methods: {
        generateLink(girl) {
          let name = 'country-city-mans-id'

          let link = this.localePath({
            name: name,
            params: {
              id: girl.id,
              country: girl.country_slug,
              city: girl.city_slug
            }
          })
          return link
        },
        getGirlAlt(girl) {
          return [
            this.$t('other.photo'),
            girl.name,
            girl.city,
            girl.age,
            this.$t('model_block.years_old')
          ].join(' ')
        },
        getGirlTitle(girl) {
          return [
            girl.name,
            girl.city,
            girl.age,
            this.$t('model_block.years_old')
          ].join(' ')
        }
      }
    }
</script>
