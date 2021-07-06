<template>
    <div class="profile__info-box" id="about">
      <h2 class="profile__section-title">{{ $t('public_profile.personal_details') }}</h2>
      <div class="profile__info-desc">
        <ul>
          <li v-if="current_girl.city || current_girl.country">
            <small>{{ $t('public_profile.base_city') }}</small><br>
            <span>
              <template v-if="current_girl.country">{{ current_girl.country.name }},</template>
              <template v-if="current_girl.city">{{ current_girl.city.name }}</template>
            </span>
          </li>
          <li v-if="current_girl.nationality">
            <small>{{ $t('public_profile.nationality') }}</small><br>
            <span>
              {{ current_girl.nationality }}
            </span>
          </li>
          <li v-if="current_girl.age">
            <small class="title">{{ $t('public_profile.age') }}</small><br>
            <span>{{ current_girl.age }}</span>
          </li>
          <li v-if="current_girl.orientation">
            <small>{{ $t('public_profile.orientation') }}</small><br>
            <span>{{ current_girl.orientation }}</span>
          </li>
          <li v-if="current_girl.height">
            <small>{{ $t('public_profile.height') }}</small><br>
            <span>
              {{ current_girl.height }}{{ $t('profile.sm') }}
            </span>
          </li>
          <li class="personal-data-item" v-if="current_girl.weight">
            <small>{{ $t('public_profile.weight') }}</small><br>
            <span>
            {{ current_girl.weight }}{{ $t('profile.kg') }}
            </span>
          </li>
          <li class="personal-data-item" v-if="current_girl.hair">
            <small>{{ $t('public_profile.hair') }}</small><br>
            <span>{{ current_girl.hair }}</span>
          </li>
          <li v-if="current_girl.eye">
            <small>{{ $t('public_profile.eyes') }}</small><br>
            <span>{{ current_girl.eye }}</span>
          </li>
          <li v-if="current_girl.meeting_with && current_girl.meeting_with.length">
            <small class="title">{{ $t('public_profile.meeting_with') }}</small><br>
            <span>
            {{ current_girl.meeting_with.join(', ') }}
          </span>
          </li>
          <li v-if="current_girl.languages.length">
            <small class="title">{{ $t('public_profile.languages') }}</small><br>
            <span>
              {{ current_girl.languages.join(', ') }}
            </span>
          </li>
          <li v-if="current_girl.geographies.length">
            <small>{{ $t('public_profile.geographies') }}</small><br>
            <span>
              {{ current_girl.geographies.join(', ') }}
            </span>
          </li>
          <li v-if="current_girl.pornstar">
            <small class="title">{{ $t('public_profile.pornstar') }}</small><br>
            <span>
              {{ $t('public_profile.pornstar_yes') }}
            </span>
          </li>
          <li v-if="incallPoints.length">
            <small class="title">{{ $t('meeting_places.incall') }}</small><br>
            <span>{{ incallPoints.join(', ') }}</span>
          </li>
          <li v-if="outcallPoints.length">
            <small class="title">{{ $t('meeting_places.outcall') }}</small><br>
            <span>{{ outcallPoints.join(', ') }}</span>
          </li>
          <li v-if="current_girl.possible_countries.length">
            <small class="title">{{ $t('public_profile.possible_countries') }}</small><br>
            <span>
            {{ current_girl.possible_countries.join(', ') }}
          </span>
          </li>
          <li v-if="current_girl.what_likes.length">
            <small class="title">{{ $t('public_profile.what_likes') }}</small><br>
            <span>
            {{ current_girl.what_likes.join(', ') }}
          </span>
          </li>
          <li v-if="current_girl.ready_fors.length">
            <small class="title">{{ $t('public_profile.ready_fors') }}</small><br>
            <span>
              {{ current_girl.ready_fors.join(', ') }}
            </span>
          </li>
        </ul>
      </div>
    </div>
  <!--
      <div class="personal-data-wrapper">

      </div>
      <div class="last-login mt-3">{{ $t('public_profile.last_login') }} {{current_girl.last_seen_at}}</div>
  -->
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

      incallPoints() {
        return this.current_girl.meeting_points
          .filter(point => point.type === 'incall')
          .map(point => this.$t('meeting_places.' + point.place))
      },

      outcallPoints() {
        return this.current_girl.meeting_points
          .filter(point => point.type === 'outcall')
          .map(point => this.$t('meeting_places.' + point.place))
      },
    }
  }
</script>
