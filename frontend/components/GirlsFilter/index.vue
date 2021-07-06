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
              :placeholder="$t('public_profile.height') + ' ' + $t('other.range_from')"
              v-validate="{numeric: true, min:0}"
              type="number"
              v-model="value.height_from"
              name="height_from"/>
          </div>

          <div class="filter__item">
            <text-input
              mode="filter"
              :placeholder="$t('public_profile.height') + ' ' + $t('other.range_to')"
              type="number"
              v-model="value.height_to"
              name="height_to"/>
          </div>

          <div class="filter__item">
            <text-input
              mode="filter"
              :placeholder="$t('public_profile.age') + ' ' + $t('other.range_from')"
              type="number"
              v-model="value.age_from"
              name="age_from"/>
          </div>

          <div class="filter__item">
            <text-input
              mode="filter"
              :placeholder="$t('public_profile.age') + ' ' + $t('other.range_to')"
              type="number"
              v-model="value.age_to"
              name="age_to"/>
          </div>

          <div class="filter__item">
            <select-with-search
              mode="filter"
              :key="'nationality' + v"
              v-if="nationalitiesFormatted.length && (showFilter || isLargeScreen)"
              :required="false"
              name="nationality"
              v-model="value.nationality"
              :placeholder="$t('public_profile.nationality')"
              :options="nationalitiesFormatted"
            />
          </div>

          <div class="filter__item">
            <select-with-search
              mode="filter"
              :key="'hairs' + v"
              v-if="hairs.length && (showFilter || isLargeScreen)"
              name="hairs"
              v-model="value.hairs"
              :searchable="false"
              :placeholder="$t('public_profile.hair')+'..'"
              :options="hairs"
              text-field="name"
              value-field="id"
            />
          </div>
          <div class="filter__item checkbox">
            <label class="filter__input">
              <input
                type="checkbox"
                name="verified"
                v-model="value.verified"
              >
              <div class="icon photo"></div>
              <span class="checkbox-text">{{ $t('public_profile.show_only_verified') }}</span>
            </label>
          </div>
          <div class="filter__item checkbox">
            <label class="filter__input">
              <input
                type="checkbox"
                name="ready_for_travels"
                v-model="value.ready_for_travels"
              >
              <div class="icon plane"></div>
              <span class="checkbox-text">{{ $t('public_profile.show_only_ready_for_travels') }}</span>
            </label>
          </div>
        </div>
        <div class="filter__choice" @click="toggleVisibility">
          <div class="btn btn-mess">{{ $t('public_profile.show') }}</div>
        </div>
        <geographies-block v-if="showGeographiesBlock"/>
      </div>
    </div>
    <div class="panel">
      <div class="filter__show" @click="toggleVisibility">
        <div class="filter__show-btn">
          <svg><use :xlink:href="cdn_assets_prefix + '/files/sprite.svg#icon--filter'"/></svg>
          <span>{{ $t('public_profile.open_filter') }}</span>
        </div>
      </div>
      <div class="panel__grid">
        <div
          class="panel__grid-item view__choice-item js_view_two"
          @click="setColumns(2)"
          :class="{active: archive_columns == 2}"
        >
          <img :src="cdn_assets_prefix +'/files/icons/svg/icon--grid.svg'" alt="">
        </div>
        <div
          class="panel__grid-item view__choice-item js_view_one"
          @click="setColumns(1)"
          :class="{active: archive_columns == 1}"
        >
          <img :src="cdn_assets_prefix + '/files/icons/svg/icon--grid-list.svg'" alt="">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import SelectWithSearch from '~/components/SelectWithSearch'
import TextInput from '~/components/TextInput'
import GeographiesBlock from './geographies'

export default {
  components: {
    SelectWithSearch,
    TextInput,
    GeographiesBlock
  },
  props: {
    showGeographiesBlock: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      closeBlockOpened: false,
      value: {
        age_from: null,
        age_to: null,
        height_from: null,
        height_to: null,
        nationality: null,
        hairs: null,
        verified: null
      },
      v: 1,
      showFilter: false,
      isLargeScreen: false
    }
  },
  computed: {
    //...mapState('filter', ['age_from', 'age_to', 'height_from', 'height_to', 'nationality', 'hairs', 'verified']),
    ...mapGetters('options', ['nationalities', 'hairs']),
    ...mapGetters(['archive_columns']),
    ...mapState({
      filter: state => state.filter.value
    }),
    nationalitiesFormatted() {
      let nationalities = [];
      this.nationalities.forEach(($nationality) => {
        nationalities.push({
          id: $nationality.id,
          text: $nationality.name
        });
      });
      return nationalities;
    }
  },
  watch: {
    value: {
      handler:
        _.debounce(function(val) {
          val.verified = val.verified ? 1 : null
          this.$store.commit('filter/UPDATE', val)
        }, 600),

      deep: true
    }
  },
  methods: {
    setColumns(count) {
      this.$store.commit('SET_ARCHIVE_COLUMNS', count)
    },
    syncStore(val) {
      return _.debounce((val) => this.$store.commit('filter/UPDATE', val), 300)
    },
    openCloseBlock() {
      this.$refs.popover.$emit('open')
      this.closeBlockOpened = true
    },
    onClose() {
      this.closeBlockOpened = false
      this.$refs.popover.$emit('close')
    },
    reset() {
      this.$store.commit('filter/reset')
      for(let i in this.filter) {
        this.value[i] = this.filter[i]
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

    this.$store.dispatch('options/fetchNationalities');
    this.$store.dispatch('options/fetchHairs');
  }
}
</script>
<style scoped>
.filter {
  display: block;
}

.no-border {
  border: none !important;
}
</style>
