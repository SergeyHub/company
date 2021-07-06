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
              :placeholder="$t('adminkas.search_query')"
              type="text"
              v-model="value.query"
              name="query"/>
          </div>

          <select-with-search
            mode="filter"
            :key="'status' + v"
            class="filter__item no-border"
            v-if="statusFormatted.length && (showFilter || isLargeScreen)"
            :required="false"
            name="status"
            v-model="value.status"
            :placeholder="$t('adminkas.status')"
            :options="statusFormatted"
          />

          <div class="filter__item">
            <date-picker
              mode="filter"
              locale="ru"
              v-model="value.created_from"
              format="yyyy.MM.dd"
              type="date"
              :placeholder="$t('adminkas.created_from')"
            ></date-picker>
          </div>


          <div class="filter__item">
            <date-picker
              mode="filter"
              locale="ru"
              v-model="value.created_to"
              format="yyyy.MM.dd"
              type="date"
              :placeholder="$t('adminkas.created_to')"
            ></date-picker>
          </div>

          <div class="filter__item">
            <select-with-search
              mode="filter"
              v-model="value.country"
              :placeholder="'Country'"
              :options="countriesFormatted"
              name="country"
              :key="'value.county' + v"
              :error="errors.first('country')"/>
          </div>

          <div class="filter__item">
            <select-with-search
              mode="filter"
              :placeholder="'City'"
              v-model="value.city"
              :options="citiesFormatted"
              name="city"
              :key="'form.cities' + v"
              :error="errors.first('city')"/>
          </div>

          <div class="filter__item checkbox">
            <label class="filter__input">
              <input
                type="checkbox"
                name="vip"
                v-model="value.vip"
              >
              <div class="icon photo"></div>
              <span class="checkbox-text">{{ $t('public_profile.show_only_vip') }}</span>
            </label>
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
        status: null,
        type: null,
        created_from: null,
        created_to: null,
        email_verified: null,
        country: null,
        city: null,
      },
      v: 1,
      showFilter: false,
      isLargeScreen: false
    }
  },
  computed: {
    ...mapGetters(['countries', 'cities']),

    countriesFormatted() {
      let countries = [];
      this.countries.forEach(($country) => {
        countries.push({
          id: $country.id,
          text: $country.name
        });
      });
      return countries;
    },
    citiesFormatted() {
      let cities = [];
      this.cities.forEach(($city) => {
        cities.push({
          id: $city.id,
          text: $city.name
        });
      });
      return cities;
    },
    statusFormatted() {
      return [
        {id: 'active', text: 'Активны'},
        {id: 'wait', text: 'Ожидают'},
        {id: 'published', text: 'Опубликованы'},
        {id: 'rejected', text: 'Отклонены'},
        {id: 'closed', text: 'Закрыты'}
      ];
    },
    typesFormatted() {
      return [
        {id: 'girls', text: 'Ескорт'},
        {id: 'travels', text: 'Путешествия'},
        {id: 'kept-womans', text: 'Содержанки'},
        {id: 'dating', text: 'Знакомства'},
        {id: 'shemales', text: 'Трансы'}
      ]
    },
    emailVerifiedAtFormatted() {
      return [
        {id: 'true', text: 'Да'},
        {id: 'false', text: 'Нет'}
      ]
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
          console.log(val)
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
        created_to: null,
        email_verified: null,
        country: null,
        city: null
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
