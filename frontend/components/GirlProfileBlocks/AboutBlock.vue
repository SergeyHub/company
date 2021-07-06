<template>
  <div class="profile__info-box">
    <h2 class="profile__section-title">{{ $t('public_profile.about') }}</h2>
    <div class="profile__info-desc">
      <p>{{ current_girl.about }}</p>
    </div>
  </div>
  <!--
  <accordion v-if="current_girl.about">
    <template slot="title">
      <h2 style="margin: 0;padding: 0">
        {{ $t('public_profile.about') }}
        {{ current_girl.name }}
        <span class="schema" itemprop="jobTitle">
          {{ $t('titles.virgin') }}
        </span>
      </h2>
    </template>
    <template slot="body">
      {{ current_girl.about }}
    </template>
  </accordion>-->
</template>

<script>
  import Accordion from '~/components/Accordion'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      Accordion
    },
    computed: {
      ...mapGetters('girls', ['current_girl'])
    }
  }
</script>
