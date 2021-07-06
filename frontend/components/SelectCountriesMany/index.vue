<template>
  <div>
    <div v-for="(country, index) in selected" :key="index+country.name" class="form-row mb-2 working-country">
      <b-col cols="4" class="text-right">{{ countryTitle }} {{ index + 1 }}</b-col>
      <b-col>
        <div class="inputContainer">
          {{ country.name }}
          <b-button @click="remove(index)" variant="primary" class="remove-selected-btn">
            <i class="fas fa-times"></i>
          </b-button>
        </div>
      </b-col>
    </div>
    <b-form-group
      label-cols-sm="4"
      :label="countryTitle"
      label-align-sm="right"
      label-size="sm"
      label-for="nested-country"
      class="select-working-country"
    >
      <div class="inputContainer">
          <b-row>
            <b-col cols="10" class="input_with_tooltip">
              <select2 :options="countriesFormatted" :searchable="true"  @change="selectedAction($event)" name="countries"></select2>
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
        selected: this.value,
        selected_ids: this.value.map(el => el.id)
      }
    },
    computed: {
      ...mapGetters(['countries']),
      ...mapGetters('auth', ['isAgency']),
      countryTitle() {
        return this.$t('profile.working_country')
      },
      countriesFormatted() {
        let countries = [];
        this.countries.forEach(($country) => {
          countries.push({
            id: $country.id,
            text: $country.name
          });
        });
        return countries;
      }
    },
    watch: {
      selected_ids: {
        immediate: true,
        handler: function(newVal, prevVal) {
          this.$emit('input', newVal)
        }
      }
    },
    methods: {
      selectedAction(value) {
        value = parseInt(value);
        if(this.selected_ids.indexOf(value) !== -1)
          return;
        var sel = this.countries[this.countries.findIndex(el => el.id === value)];
        this.selected.push(sel)
        this.selected_ids.push(value)
      },
      remove(index) {
        this.selected.splice(index, 1)
        this.selected_ids.splice(index, 1)
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
