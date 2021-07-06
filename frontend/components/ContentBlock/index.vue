<template>
  <div class="page__text">
    <div class="container">
      <content-placeholders
        class="content-placeholders"
        :rounded="true"
        v-if="loading"
      >
        <content-placeholders-heading />
        <content-placeholders-text :lines="3" />
      </content-placeholders>
      <div v-html="contentText" v-else></div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import { EventBus } from '~/utils/event-bus'

  export default {
    props: {
      slug: {
        type: String,
        required: true
      }
    },

    computed: {
      ...mapGetters(['country', 'city']),

      contentText() {
        if(this.loading)
          return '';
        if(!this.content || !this.content.content)
          return '';
        var text = this.content.content;
        // заменяем шаблонныве слова
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
          .replace(/%in_city%/gi, (this.city && this.city.id ?  this.city.name_prepositional : ''))
          .replace(/%from_country%/gi, (this.country && this.country.id ? ' ' + this.$t('other.from') + (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : ''))
          .replace(/%country_or_city%/gi,
            this.city && this.city.id
              ? (this.$t('other.in_the') + this.city.name_prepositional )
              : (this.country && this.country.id ? (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : '')
          )
          .replace(/%from_country_or_city%/gi,
            this.city && this.city.id
              ? (this.$t('other.from') + this.city.name_prepositional )
              : (this.country && this.country.id ? this.$t('other.from') + (this.country.name_prepositional ? this.country.name_prepositional : this.country.name) : '')
          )
          .replace(/col-md-6/gi, 'col-6 col-md-6 col-sm-12');
      }
    },

    data() {
      return {
        loading: true,
        content: {}
      }
    },

    methods: {
      fetchContent() {
        this.loading = true;
        this.$store.dispatch('content/fetchContent', this.slug)
          .then((response) => {
            this.content = response.data;
            this.loading = false;
          })
          .catch(() => {
            this.loading = false;
          })
      }
    },

    mounted() {
      this.fetchContent();

      EventBus.$on('langChanged', () => {
        this.fetchContent()
      })
    }
  }
</script>
