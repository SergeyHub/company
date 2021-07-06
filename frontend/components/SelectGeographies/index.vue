<template>
  <div>
    <div v-for="(geography, index) in selected" :key="index+geography.name" class="form-row mb-2 working-geography">
      <b-col cols="4" class="text-right">{{ gegographyTitle }} {{ index + 1 }}</b-col>
      <b-col>
        <div class="inputContainer">
          {{ geography.name }}
          <b-button @click="remove(index)" variant="primary" class="remove-selected-btn">
            <i class="fas fa-times"></i>
          </b-button>
        </div>
      </b-col>
    </div>
    <b-form-group
      label-cols-sm="4"
      :label="gegographyTitle"
      label-align-sm="right"
      label-size="sm"
      label-for="nested-geography"
      class="select-working-geography"
    >
      <div class="inputContainer">
          <b-row>
            <b-col cols="10" class="input_with_tooltip">
              <b-form-select
                size="sm"
                text-field="name"
                value-field="id"
                @input="selectedAction"
                :options="geographies"
              />
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
      ...mapGetters('options', ['geographies']),
      ...mapGetters('auth', ['isAgency']),
      gegographyTitle() {
        if (this.isAgency) {
          return this.$t('profile.work_geography')
        }
        return this.$t('profile.where_ready_to_go')
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
        if(this.selected_ids.indexOf(value) !== -1)
          return;
        var sel = this.geographies[this.geographies.findIndex(el => el.id === value)];
        this.selected.push(sel)
        this.selected_ids.push(value)
      },
      remove(index) {
        this.selected.splice(index, 1)
        this.selected_ids.splice(index, 1)
      }
    },
    async mounted() {
      if(!this.$store.state.options.geographies.length)
          await this.$store.dispatch('options/fetchGeographies')
    }
  }
</script>

<style>
  .working-geography {
    font-size: 14px;
  }
  .working-geography button {
    padding: 6px;
    border-radius: 100%;
    line-height: 0.5;
    font-size: 12px;
  }
  .select-working-geography label {
    line-height: 1.3;
  }
</style>
