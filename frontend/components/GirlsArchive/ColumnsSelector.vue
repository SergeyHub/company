<template>
  <modal ref="modal">
    <div class="view">
      <div class="view__wrap">
        <div class="title">{{ $t('archive.select_view') }} <br>
          {{ $t('archive.of_model_cards') }}</div>
        <div class="view__choice">
          <div class="view__choice-item js_view_two" data-column="2">
            <img :src="cdn_assets_prefix + '/files/icons/svg/icon--col-2.svg'" alt="">
            <span>{{ $t('archive.2_columns') }}</span>
            <div
              class="view__choice-btn"
              @click="select(2)"
            >
              {{ $t('archive.select') }}
            </div>
          </div>
          <div class="view__choice-item" data-column="1">
            <img :src="cdn_assets_prefix + '/files/icons/svg/icon--col-1.svg'" alt="">
            <span>{{ $t('archive.1_column') }}</span>
            <div
              class="view__choice-btn"
              @click="select(1)"
            >
              {{ $t('archive.select') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>
<script>
import Modal from '~/components/Modal'

export default {
  components: {
    Modal
  },
  methods: {
    open() {
      this.$refs.modal.open()
    },
    close() {
      this.$refs.modal.close()
    },
    select(count) {
      this.$store.commit('SET_ARCHIVE_COLUMNS', count)
      this.close()
    }
  }
}
</script>
<style scoped>
.view__wrap .title {
  text-align: center;
}
</style>
