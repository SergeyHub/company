<template>
  <div id="reviews" class="profile__section profile__reviews reviews">
    <div class="container">
      <div class="profile__section-title">
        <h4> {{ $t('public_profile.reviews') }} </h4> <ins> {{ current_girl.reviews.length }}</ins>
        <small class="btn-reviews" @click="$emit('showReviewModal')">+ {{ $t('public_profile.write_review') }}</small>
      </div>

      <div class="reviews__row">
        <div
          class="reviews__item"
          v-for="(review, index) in current_girl.reviews"
          :key="'review/'+index"
        >
          <div class="reviews__item-avatar">
            <img :src="cdn_assets_prefix + '/images/archive/reviews/avatar.jpg'" alt="">`
            <div class="reviews__item-avatar-title">
              {{ review.nickname }}
            </div>
          </div>
          <div class="reviews__item-desc">
            <div class="reviews__item-meta">
              <div class="reviews__item-meta-data">{{ review.created_at }}</div>
              <div class="reviews__item-meta-stars">
                <ul>
                  <li class="on" v-for="i in Number(review.stars)" :key="i"></li>
                </ul>
              </div>
            </div>
            <div class="reviews__item-content">{{ review.review }}</div>
          </div>
        </div>
      </div>
      <AppButton mode="dark" @click.native="$emit('showReviewModal')">{{ $t('public_profile.write_review') }}</AppButton>

      <!--<div class="reviews__row">
        <div
          v-for="(review, index) in current_girl.reviews"
          :key="'review/'+index"
          class="reviews__item"
        >
          <div class="reviews__item-avatar">
            <img :src="cdn_assets_prefix + '/assets/images/archive/reviews/avatar.jpg'" alt="">
            <div class="reviews__item-avatar-title">
              {{review.nickname}}
            </div>
          </div>
          <div class="reviews__item-desc">
            <div class="reviews__item-meta">
              <div class="reviews__item-meta-data">08 марта 2020 г.</div>
              <!-<div class="reviews__item-meta-stars">
                <ul>
                  <li class="on"></li>
                  <li class="on"></li>
                  <li class="on"></li>
                  <li class="on"></li>
                  <li class=""></li>
                </ul>
              </div>->
            </div>
            <div class="reviews__item-content" >{{ review.review }}</div>
          </div>
        </div>
      </div>

      <div class="btn btn-border btn-reviews" @click="$emit('writeReview')">{{$t('public_profile.write_review')}}</div>-->
    </div>
  </div>
  <!--
  <accordion icon="fa-edit">
    <template slot="title">
      {{ $t('public_profile.reviews') }}
    </template>
    <template slot="body">
      <slick
        class="reviews-slick"
        ref="slick"
        :options="slickOptions">
        <div class="col-md-12 mr-2 ml-2" v-for="(review, index) in current_girl.reviews" :key="'review/'+index">
          <span class="review-author text-muted">
            <span>
               {{review.nickname}},
            </span>
            <span>
                {{review.meeting_date}}
            </span>
          </span>
          <div class="mb-1 mt-1">
            {{review.review}}
          </div>
          <div>{{$t('public_profile.meeting_country')}}: {{review.country}}</div>
          <div>{{$t('public_profile.meeting_city')}}: {{review.meeting_city}}</div>
          <div>{{$t('public_profile.duration')}}: {{review.duration}} ({{$t('public_profile.'+review.duration_type)}})</div>
          <div>{{$t('public_profile.price')}}: {{review.price}} {{review.currency}}</div>
        </div>
      </slick>
      <div class="col-md-12" v-if="!current_girl.reviews.length">
        {{$t('public_profile.not_reviews')}}
      </div>
      <div class="reviews-write text-center">
        <span class="write-review-button" @click="$refs.write_review.open()">{{$t('public_profile.write_review')}}</span>
      </div>
      <review-modal ref="write_review"></review-modal>
    </template>
  </accordion>-->
</template>

<script>
  import Accordion from '~/components/Accordion'
  import AppButton from '~/components/AppButton'
  import ReviewModal from '~/components/ReviewModal'
  import {mapGetters} from "vuex";

  export default {
    components: {
      Accordion,
      ReviewModal,
      AppButton
    },
    computed: {
      ...mapGetters('girls', ['current_girl']),
    },
    data() {
      return {
        slickOptions: {
          slidesToShow: 1,
          arrows: true,
          infinite: true,
          centerMode: false,
        },
      }
    },

  }
</script>
<style lang="scss">
  .write-review-button {
    cursor: pointer;
    font-weight: bold;
    &:hover {
      color: #ec048a;
    }
  }
  .reviews-write {
    line-height: 3rem;
    margin-top: 20px;
    box-shadow: inset 0 1px 0 0 rgba(0,0,0,.1);
  }
  .reviews-slick {
    .slick-prev,
    .slick-next {
      &,
      &:hover,
      &:focus{
        height: 25px;
        z-index: 20;
        background-size: 36px;
        background-position: -10px -10px;
        background-color: #fa6b6b;
        border-radius: 100%;
        width: 25px;
        border: 4px solid #fa6b6b;
      }
    }
    .slick-next {
      &,
      &:hover,
      &:focus{
        right: -10px;
        background-position: -20px -25px;
      }
    }
    .slick-prev {
      &,
      &:hover,
      &:focus{
        left: -10px;
        background-position: -34px -25px;
      }
    }
  }
</style>
