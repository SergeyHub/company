<template>
  <v-date-picker
    v-model="date"
    mode='date'
    is-dark
    :locale="locale"
    :masks="masks"
  >
    <template v-slot="{ inputValue, inputEvents, showPopover}">
      <input
        :placeholder="placeholder"
        class="input"
        :class="{'filter__input': mode == 'filter' }"
        :value="inputValue"
        v-on="inputEvents"
      />
    </template>
  </v-date-picker>
</template>
<script>
  export default {
    props: {
      placeholder: {
        type: String,
        default: ''
      },
      mode: {
        default: 'profile'
      },
      value: {
        default: null
      }
    },
    computed: {
      locale() {
        return this.$i18n.locale
      }
    },
    created() {
      this.date = this.value
    },
    data() {
      return {
        date: null,
        masks: {
          input: 'YYYY-MM-DD',
          iso: 'YYYY-MM-DD',
          data: 'YYYY-MM-DD',
        },
      }
    },
    watch: {
      date(val) {
        this.$emit('input', val)
      },
      value(value) {
        this.date = value
      }
    }
  }
</script>
<style scoped>
input {
  max-width: unset !important;
}
</style>
