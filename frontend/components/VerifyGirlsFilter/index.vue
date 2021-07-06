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
            <text-input
              mode="filter"
              :placeholder="$t('adminkas.search_query') + ' анкеты'"
              type="text"
              v-model="value.query"
              name="query"/>
          </div>
          <div class="filter__item">
            <select-with-search
              mode="filter"
              :key="'verified' + v"
              v-if="verifiedFormatted.length && (showFilter || isLargeScreen)"
              :required="false"
              name="verified"
              v-model="value.verified"
              :placeholder="$t('adminkas.status')"
              :options="verifiedFormatted"
            />
          </div>

          <div class="filter__item">
            <date-picker
              mode="filter"
              locale="ru"
              v-model="value.verification_applicated_from"
              format="yyyy.MM.dd"
              type="date"
              :placeholder="$t('adminkas.verification_applicated_from')"
            ></date-picker>
          </div>

          <div class="filter__item">
            <date-picker
              mode="filter"
              locale="ru"
              v-model="value.verification_applicated_to"
              format="yyyy.MM.dd"
              type="date"
              :placeholder="$t('adminkas.verification_applicated_to')"
            ></date-picker>
          </div>

          <div class="filter__item">
            <date-picker
              mode="filter"
              locale="ru"
              v-model="value.verificated_from"
              format="yyyy.MM.dd"
              type="date"
              :placeholder="$t('adminkas.verificated_from')"
            ></date-picker>
          </div>

          <div class="filter__item">
            <date-picker
              mode="filter"
              locale="ru"
              v-model="value.verificated_to"
              format="yyyy.MM.dd"
              type="date"
              :placeholder="$t('adminkas.verificated_to')"
            ></date-picker>
          </div>
        </div>
        <div class="filter__choice" @click="toggleVisibility">
          <div class="btn btn-mess">{{ $t('public_profile.show') }}</div>
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
import { mapGetters, mapState } from 'vuex'
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
        query: null,
        verified: null,
        verification_applicated_from: null,
        verification_applicated_to: null,
        verificated_from: null,
        verificated_to: null
      },
      v: 1,
      showFilter: false,
      isLargeScreen: false
    }
  },
  computed: {
    ...mapGetters(['countries', 'cities']),

    verifiedFormatted() {
      return [
        {id: 'yes', text: 'Верифицированы'},
        {id: 'wait', text: 'Ожидают'},
        {id: 'no', text: 'Не верифицированы'},
        {id: 'rejected', text: 'Отклонены'}
      ];
    }
  },
  watch: {
    'value.country': {
      deep: true,
      handler(newVal, prevVal) {
        if(newVal == null) {
          this.$store.commit('SET_CITIES', [])
          return;
        };

        this.$store.dispatch('getCitiesForCountry', newVal)
      }
    },
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
        verified: null,
        verification_applicated_from: null,
        verification_applicated_to: null,
        verificated_from: null,
        verificated_to: null
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
  async mounted() {
    this.updateFilterVisibility()
    window.onresize = this.updateFilterVisibility

    await this.$store.dispatch('setCountries');
  }
}
</script>
