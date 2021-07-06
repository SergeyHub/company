<template>
  <div class="container">
    <template v-if="error.statusCode == 404">
      <h1>{{ $t('errors.404_title') }}</h1>
      <p>{{ $t('errors.404_description') }}</p>
    </template>
    <template v-else-if="error.statusCode == 500">
      <h1>{{ $t('errors.500_title') }}</h1>
      <p>{{ $t('errors.500_description') }}</p>
    </template>
    <template v-else>
      <h1>{{ error.statusCode }}</h1>
      <p>{{ error.message }}</p>
    </template>

    <div class="admin__profile-input">
      <AppButton
        mode="accent"
        @click.native="openSearchModal"
      >
        {{ $t('errors.search_form') }}
      </AppButton>
    </div>
    <div class="admin__profile-input">
      <router-link :to="localePath('virgins')">
        <AppButton mode="dark" class="btn-border">{{ $t('errors.home') }}</AppButton>
      </router-link>
    </div>
  </div>
</template>
<script>
  import AppButton from '~/components/AppButton'

  export default {
    props: ['error'],
    layout: 'errorLayout',
    components: {
      AppButton
    },
    methods: {
      openSearchModal() {
        this.$searchModal.open()
      }
    }
  }
</script>
<style lang="scss" scoped>

</style>
