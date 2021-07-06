<template>
  <checkbox-group
    class="admin__profile-item center"
    :label="$t('profile.ready_for')"
    :options="readyFor"
    v-model="selected_ids"
    textField="name"
    valueField="id"
  />
  <!--<div>
    <div v-for="(ready, index) in selected" :key="index+ready.name" class="form-row mb-2 working-ilike">
      <b-col cols="4" class="text-right">{{$t('profile.ready_for')}} {{ index + 1 }}</b-col>
      <b-col>
        <div class="inputContainer">
          {{ ready.name }}
          <b-button @click="remove(index)" variant="primary" class="remove-selected-btn">
            <i class="fas fa-times"></i>
          </b-button>
        </div>
      </b-col>
    </div>
    <b-form-group
      label-cols-sm="4"
      :label="$t('profile.ready_for')"
      label-align-sm="right"
      label-size="sm"
      label-for="nested-ilike"
      class="select-working-ilike"
    >
      <div class="inputContainer">
          <b-row>
            <b-col cols="10" class="input_with_tooltip">
              <b-form-select
                size="sm"
                text-field="name"
                value-field="id"
                @input="selectedAction"
                :options="readyFor"
              />
            </b-col>
          </b-row>
      </div>
    </b-form-group>
  </div>-->
</template>

<script>
  import CheckboxGroup from '~/components/CheckboxGroup'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      CheckboxGroup
    },
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
      ...mapGetters('options', ['readyFor']),
      ...mapGetters('auth', ['isAgency']),
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
        var sel = this.readyFor[this.readyFor.findIndex(el => el.id === value)];
        this.selected.push(sel)
        this.selected_ids.push(value)
      },
      remove(index) {
        this.selected.splice(index, 1)
        this.selected_ids.splice(index, 1)
      }
    },
    async mounted() {
      if(!this.$store.state.options.readyFor.length)
          await this.$store.dispatch('options/fetchReadyFor')
    }
  }

</script>

<style>
  .working-ilike {
    font-size: 14px;
  }
  .working-ilike button {
    padding: 6px;
    border-radius: 100%;
    line-height: 0.5;
    font-size: 12px;
  }
  .select-working-ilike label {
    line-height: 1.3;
  }
</style>
