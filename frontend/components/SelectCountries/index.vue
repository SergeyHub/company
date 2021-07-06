<template>
  <div>
    <b-row v-for="(country, index) in selected_countries" :key="index+country.name" class="form-row mb-2 working-country">
      <b-col cols="5" class="text-right">{{ $t('profile.dating_country') }}</b-col>
      <b-col>
        <div class="inputContainer">
          {{ country.name }}
          <b-button @click="remove(index)" variant="primary" class="remove-selected-btn">
            <i class="fas fa-times"></i>
          </b-button>
        </div>
      </b-col>
    </b-row>
    <b-form-group
      label-cols-sm="5"
      :label="$t('profile.add_dating_country')"
      label-align-sm="right"
      label-size="sm"
      label-for="nested-country"
      class="select-working-country"
    >
      <div class="inputContainer mt-2">
        <b-row>
          <b-col cols="10" class="input_with_tooltip">
            <b-form-select
              size="sm"
              text-field="name"
              value-field="id"
              @input="countrySelected"
              :options="countries"
            />
          </b-col>
          <b-col cols="2" class="question_block">
            <i class="far fa-question-circle" v-b-tooltip.html :title="$t('profile.dating_country_tooltip')"></i>
          </b-col>
        </b-row>
      </div>
    </b-form-group>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    props: {
      value: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        selected_countries: this.value,
        selected_countries_ids: this.value.map(el => el.id)
      }
    },
    computed: {
      ...mapGetters(['countries']),
    },
    watch: {
      selected_countries_ids: {
        immediate: true,
        handler: function(newVal, prevVal) {
          this.$emit('input', newVal)
        }
      }
    },
    methods: {
      countrySelected(value) {
        if(this.selected_countries_ids.indexOf(value) !== -1)
          return;
        var country = this.countries[this.countries.findIndex(el => el.id === value)];
        this.selected_countries.push(country)
        this.selected_countries_ids.push(value)
      },
      remove(index) {
        this.selected_countries.splice(index, 1)
        this.selected_countries_ids.splice(index, 1)
      }
    },
    async mounted() {
      if(!this.$store.state.countries.length)
          await this.$store.dispatch('setCountries')
    }
  }
</script>

<style>
  .working-country {
    font-size: 14px;
  }
  .working-country button {
    padding: 6px;
    border-radius: 100%;
    line-height: 0.5;
    font-size: 12px;
  }
  .select-working-country label {
    line-height: 1.3;
  }
</style>
