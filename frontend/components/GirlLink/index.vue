<template>
  <router-link
    :to="modelLink"
    :alt="modelAlt"
    :title="modelTitle"
    :tag="tag"
  >
    <slot/>
  </router-link>
</template>
<script>
export default {
  props: {
    model: Object,
    tag: {
      default: 'a'
    }
  },
  computed: {
    modelLink() {
      let name = 'country-city-mans-id'

      let link = this.localePath({
        name: name,
        params: {
          id: this.model.id,
          country: this.model.country_slug,
          city: this.model.city_slug
        }
      })
      return link
    },
    modelTitle() {
      return [
        this.model.name,
        this.model.city,
        this.model.age,
        this.$t('model_block.years_old')
      ].join(' ')
    },
    modelAlt() {
      return [
        this.$t('other.photo'),
        this.model.name,
        this.model.city,
        this.model.age,
        this.$t('model_block.years_old')
      ].join(' ')
    }
  }
}
</script>
