<template>
  <div>
    <div class="filter" v-show="showFilter || isLargeScreen">
      <div class="filter__close" @click="toggleVisibility"></div>
      <div class="container">
        <div class="filter__title">
          <span>{{ $t('other.filter') }}</span>
          <div
            @click="reset"
            class="clear">
            {{ $t('other.reset_filter') }}
          </div>
        </div>
        <div class="filter__wrap">
          <div class="filter__item">
            <select-with-search
              mode="filter"
              v-if="statusesFormatted.length && (showFilter || isLargeScreen)"
              :key="'type' + v"
              :required="false"
              name="type"
              v-model="value.published"
              :placeholder="$t('adminkas.status')"
              :options="statusesFormatted"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="panel">
      <div class="filter__show" @click="toggleVisibility">
        <div class="filter__show-btn">
          <svg><use :xlink:href="cdn_assets_prefix + '/files/icons/svg/sprite.svg#icon--filter'"/></svg>
          <span>{{ $t('public_profile.open_filter') }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
import SelectWithSearch from '~/components/SelectWithSearch'
import TextInput from '~/components/TextInput'
import SelectInput from '~/components/SelectInput'

export default {
  components: {
    SelectWithSearch,
    TextInput,
    SelectInput
  },
  data() {
    return {
      closeBlockOpened: false,
      value: {
        published: false
      },
      v: 1,
      showFilter: false,
      isLargeScreen: false
    }
  },
  computed: {
    ...mapGetters(['archive_columns']),
    statusesFormatted() {
      return [
        {id: 'true', text: 'Опубликован'},
        {id: 'false', text: 'Не опубликован'}
      ];
    }
  },
  watch: {
    value: {
      handler:
        _.debounce(function(val) {
          this.$emit('update', val)
        }, 600),

      deep: true
    }
  },
  methods: {
    openCloseBlock() {
      this.$refs.popover.$emit('open')
      this.closeBlockOpened = true
    },
    onClose() {
      this.closeBlockOpened = false
      this.$refs.popover.$emit('close')
    },
    reset() {
      this.value = {
        query: null,
        status: null,
        type: null,
        created_from: null,
        created_to: null
      }

      this.v = Math.random() * 9999
    },
    toggleVisibility() {
      this.showFilter = !this.showFilter
    },
    updateFilterVisibility() {
      this.isLargeScreen = !process.client ? false : window.innerWidth > 1040
    }
  },
  mounted() {
    this.updateFilterVisibility()
    window.onresize = this.updateFilterVisibility

  }
}
</script>
