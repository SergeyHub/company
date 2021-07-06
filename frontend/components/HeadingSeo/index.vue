<template>
  <div class="page__title">
    <div class="container">
      <h1>{{ title }}</h1>
      <p>{{ heading_seo_text }}</p>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  //import BButton from "bootstrap-vue/src/components/button/button";

  let sectionsArr = [
    'reviews',
    'agencies',
    'videos',
    'pornstars',
    'shemales',
    'dating',
    'travels',
    'top50'
  ]
  let sectionsWithCity = [
    'reviews',
    'pornstars',
    'shemales',
    'dating',
    'top50',
    'videos'
  ]

  export default {
    components: { },
    computed: {
      ...mapGetters(['country', 'city']),
      ...mapGetters('girls', ['section']),
      geography_global() {
        return this.$store.getters.geography;
      },

      title() {
        let text = '';
        if (sectionsArr.includes(this.section)) {
          if (this.city && this.city.id && sectionsWithCity.includes(this.section)) {
            switch (this.section) {
              case 'reviews':
                text = this.$t('heading_seo.city_reviews_title');
                break;
              case 'pornstars':
                text = this.$t('heading_seo.city_pornstars_title');
                break;
              case 'dating':
                text = this.$t('heading_seo.city_dating_title');
                break;
              case 'shemales':
                text = this.$t('heading_seo.city_shemales_title');
                break;
              case 'top50':
                text = this.$t('heading_seo.city_top50_title');
                break;
              case 'videos':
                text = this.$t('heading_seo.city_videos_title')
                break;
            }
          } else if (this.country && this.country.id) {
            switch (this.section) {
              case 'videos':
                text = this.$t('heading_seo.country_videos_title')
                break;
              case 'reviews':
                text = this.$t('heading_seo.country_reviews_title');
                break;
              case 'agencies':
                text = this.$t('heading_seo.country_agencies_title');
                break;
              case 'pornstars':
                text = this.$t('heading_seo.country_pornstars_title');
                break;
              case 'dating':
                text = this.$t('heading_seo.country_dating_title');
                break;
              case 'shemales':
                text = this.$t('heading_seo.country_shemales_title');
                break;
              case 'travels':
                if (this.geography_global && this.geography_global.id) {
                  text = this.$t('heading_seo.country_geography_travels_title');
                } else {
                  text = this.$t('heading_seo.country_travels_title');
                }
                break;
              case 'top50':
                text = this.$t('heading_seo.country_top50_title');
                break;
            }
          } else {
            switch (this.section) {
              case 'videos':
                return this.$t('heading_seo.videos_title');
                break;
              case 'reviews':
                return this.$t('heading_seo.reviews_title');
                break;
              case 'agencies':
                return this.$t('heading_seo.agencies_title');
                break;
              case 'pornstars':
                return this.$t('heading_seo.pornstars_title');
                break;
              case 'dating':
                return this.$t('heading_seo.dating_title');
                break;
              case 'shemales':
                return this.$t('heading_seo.shemales_title');
                break;
              case 'travels':
                return this.$t('heading_seo.travels_title');
                break;
              case 'top50':
                return this.$t('heading_seo.top50');
                break;
            }
          }
        } else {
          if (this.city && this.city.id) {
            text = this.$t('heading_seo.city_title');
            console.log('LLLL', text)
          } else if (this.country && this.country.id) {
            text = this.$t('heading_seo.country_title');
          } else {
            return this.$t('heading_seo.title_main');
          }
        }
        return text.replace(/%country_prepositional%/gi, (this.country && this.country.id ? (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : ''))
          .replace(/%country_genitive%/gi, (this.country && this.country.id ? (this.country.name_genitive ? this.country.name_genitive : this.country.name) : ''))
          .replace(/%country_instrumental%/gi, (this.country && this.country.id ? (this.country.name_instrumental ? this.country.name_instrumental : this.country.name) : ''))
          .replace(/%country_dative%/gi, (this.country && this.country.id ? (this.country.name_dative ? this.country.name_dative : this.country.name) : ''))
          .replace(/%country_accusative%/gi, (this.country && this.country.id ? (this.country.name_accusative ? this.country.name_accusative : this.country.name) : ''))
          .replace(/%city_prepositional%/gi, (this.city && this.city.id ? (this.city.name_prepositional ? this.city.name_prepositional : this.city.name) : ''))
          .replace(/%city_genitive%/gi, (this.city && this.city.id ? (this.city.name_genitive ? this.city.name_genitive : this.city.name) : ''))
          .replace(/%city_instrumental%/gi, (this.city && this.city.id ? (this.city.name_instrumental ? this.city.name_instrumental : this.city.name) : ''))
          .replace(/%city_dative%/gi, (this.city && this.city.id ? (this.city.name_dative ? this.city.name_dative : this.city.name) : ''))
          .replace(/%city_accusative%/gi, (this.city && this.city.id ? (this.city.name_accusative ? this.city.name_accusative : this.city.name) : ''))
          .replace(/%country%/gi, (this.country && this.country.id ? this.country.name : ''))
          .replace(/%city%/gi, (this.city && this.city.id ? this.city.name : ''))
          .replace(/%geography%/gi, (this.geography_global && this.geography_global.id) ? this.geography_global.name : '')
          .replace(/%geography_accusative%/gi, (this.geography_global && this.geography_global.id) ? this.geography_global.name_accusative : '')
      },
      heading_seo_text() {
        let text = '';
        if (sectionsArr.includes(this.section)) {
          if (this.city && this.city.id && sectionsWithCity.includes(this.section)) {
            switch (this.section) {
              case 'reviews':
                text = this.$t('heading_seo.text_reviews_city');
                break;
              case 'pornstars':
                text = this.$t('heading_seo.text_pornstars_city');
                break;
              case 'dating':
                text = this.$t('heading_seo.text_dating_city');
                break;
              case 'shemales':
                text = this.$t('heading_seo.text_shemales_city');
                break;
              case 'top50':
                text = this.$t('heading_seo.city_top50_text');
                break;
              case 'videos':
                text = this.$t('heading_seo.city_text_videos')
                break;
            }
          } else if (this.country && this.country.id) {
            switch (this.section) {
              case 'videos':
                text = this.$t('heading_seo.country_text_videos')
                break;
              case 'reviews':
                text = this.$t('heading_seo.text_reviews_country');
                break;
              case 'agencies':
                text = this.$t('heading_seo.text_agencies_country');
                break;
              case 'pornstars':
                text = this.$t('heading_seo.text_pornstars_country');
                break;
              case 'dating':
                text = this.$t('heading_seo.text_dating_country');
                break;
              case 'shemales':
                text = this.$t('heading_seo.text_shemales_country');
                break;
              case 'travels':
                if (this.geography_global && this.geography_global.id) {
                  text = this.$t('heading_seo.text_travels_country_geography');
                } else {
                  text = this.$t('heading_seo.text_travels_country');
                }
                break;
              case 'top50':
                text = this.$t('heading_seo.country_text_top50');
                break;
            }
          } else {
            switch (this.section) {
              case 'videos':
                return this.$t('heading_seo.text_videos');
                break;
              case 'reviews':
                return this.$t('heading_seo.text_reviews');
                break;
              case 'agencies':
                return this.$t('heading_seo.text_agencies');
                break;
              case 'pornstars':
                return this.$t('heading_seo.text_pornstars');
                break;
              case 'dating':
                return this.$t('heading_seo.text_dating');
                break;
              case 'shemales':
                return this.$t('heading_seo.text_shemales');
                break;
              case 'travels':
                return this.$t('heading_seo.text_travels');
                break;
              case 'top50':
                return this.$t('heading_seo.text_top50');
                break;
            }
          }
        } else {
          if (this.city && this.city.id) {
            text = this.$t('heading_seo.text_city');
          } else if (this.country && this.country.id) {
            text = this.$t('heading_seo.text_country');
          } else {
            return this.$t('heading_seo.text');
          }
        }
        return text.replace(/%country_prepositional%/gi, (this.country && this.country.id ? (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : ''))
          .replace(/%country_genitive%/gi, (this.country && this.country.id ? (this.country.name_genitive ? this.country.name_genitive : this.country.name) : ''))
          .replace(/%country_instrumental%/gi, (this.country && this.country.id ? (this.country.name_instrumental ? this.country.name_instrumental : this.country.name) : ''))
          .replace(/%country_dative%/gi, (this.country && this.country.id ? (this.country.name_dative ? this.country.name_dative : this.country.name) : ''))
          .replace(/%country_accusative%/gi, (this.country && this.country.id ? (this.country.name_accusative ? this.country.name_accusative : this.country.name) : ''))
          .replace(/%city_prepositional%/gi, (this.city && this.city.id ? (this.city.name_prepositional ? this.city.name_prepositional : this.city.name) : ''))
          .replace(/%city_genitive%/gi, (this.city && this.city.id ? (this.city.name_genitive ? this.city.name_genitive : this.city.name) : ''))
          .replace(/%city_instrumental%/gi, (this.city && this.city.id ? (this.city.name_instrumental ? this.city.name_instrumental : this.city.name) : ''))
          .replace(/%city_dative%/gi, (this.city && this.city.id ? (this.city.name_dative ? this.city.name_dative : this.city.name) : ''))
          .replace(/%city_accusative%/gi, (this.city && this.city.id ? (this.city.name_accusative ? this.city.name_accusative : this.city.name) : ''))
          .replace(/%country%/gi, (this.country && this.country.id ? this.country.name : ''))
          .replace(/%city%/gi, (this.city && this.city.id ? this.city.name : ''))
          .replace(/%geography%/gi, (this.geography_global && this.geography_global.id) ? this.geography_global.name : '')
          .replace(/%geography_accusative%/gi, (this.geography_global && this.geography_global.id) ? this.geography_global.name_accusative : '')
      }
    },

    data() {
      return {
      }
    }
  }
</script>
<style scoped>
  h1 {
    font-family: "RobotoRegular";
  }
</style>
