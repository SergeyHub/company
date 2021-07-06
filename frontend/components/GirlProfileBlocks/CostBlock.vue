<template>
  <div
    class="profile__section-row justify-content"
    id="price"
  >
    <div class="profile__section-col-2">
      <div class="profile__price">
        <div class="profile__price-row">
          <h3 class="profile__price-title">{{ $t('public_profile.tariffs') }}:</h3>
          <div
            v-for="(cost, index) in costs"
            :key="index"
            class="profile__price-item"
          >
            <span>{{ $t('durations.' + cost.duration) }}</span>
            <strong>{{ cost.amount }} {{ cost.currency.title }}</strong>
          </div>
        </div>
      </div>
    </div>
    <div class="profile__section-col-2">
      <div class="profile__usser-data">
        <div class="profile__usser-data-view">
          <span>{{ $t('public_profile.views') }}</span>
          <strong>{{ current_girl.views }}</strong>
        </div>
        <div class="profile__usser-data-reg">
          <span>{{ $t('public_profile.registered') }}</span>
          <strong>{{ current_girl.created_at }}</strong>
        </div>
      </div>
    </div>
  </div>
  <!--
  <div>
    <div style="margin-bottom: 15px">
      <div class="document_verified_block" v-if="current_girl.verified==='yes'">
        <i class="document_verified_icon fas fa-check-circle"></i>
        <span>{{ $t('public_profile.verified') }}</span>
      </div>
      <div class="document_verified_block not_verified" v-else>
        <i class="document_not_verified_icon fas fa-exclamation-circle"></i>
        <span>{{ $t('public_profile.not_verified') }}</span>
      </div>
    </div>
    <accordion icon="fa-dollar-sign" class="detail-block-prices">
      <template slot="title">
        Prices
      </template>
      <template slot="body" class="detail-block-prices">
        <div class="prices-wrapper">
          <div
            class="price-item"
            v-for="(cost, index) in current_girl.costs"
            :key="index"
          >
            <div class="price-time">
              {{ $t('durations.' + cost.duration) }}
            </div>
            <div class="price-amount">
              <span>{{ cost.amount }}</span>
              <span>{{ cost.currency.title }}</span>
            </div>
          </div>
        </div>
      </template>
    </accordion>
  </div>-->
</template>

<script>
  import Accordion from '~/components/Accordion'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      Accordion
    },
    computed: {
      ...mapGetters('girls', ['current_girl']),
      costs() {
        let costs = [...this.current_girl.costs]
        return costs.sort((a,b) => parseInt(a.duration) - parseInt(b.duration))
      }
    }
  }
</script>
