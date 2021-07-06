<template>
  <div>
    <label class="input-lable price">{{ $t('profile.cost') }}</label>

    <div
      class="admin__profile-item"
      v-for="(row, index) in costs"
      :key="index"
    >
      <div class="admin__profile-item-wrap">
        <div class="admin__profile-item-title">
          {{ $t('durations.' + row.duration) }}
        </div>
        <div class="admin__profile-item-input price">
          <text-input
            type="number"
            min="1"
            max="100000"
            :value="row.amount"
            :placeholder="0"
            @input="updateAmount(index, $event)"
          />
        </div>
        <div class="admin__profile-item-type">
          <SelectNative
            @input="selectCurrency(index, $event)"
            :options="currencies"
            :value="row.currency_id"
            :type="'native'"
            valueField="id"
            textField="title"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import TextInput from '~/components/TextInput'
  import SelectNative from '~/components/SelectNative'

  export default {
    components: {
      TextInput,
      SelectNative
    },
    props: {
      value: {
        type: Array,
        default: () => []
      }
    },
    data() {
      const durations = ['1_hour', '2_hour', '3_hour', '12_hour', '24_hour'];

      const costs = durations.map(duration => {
          const findedIndex = this.value.findIndex(cost => cost.duration === duration);
          const findedCost = findedIndex !== -1 ? this.value[findedIndex] : null;
          return {
            duration,
            amount: findedCost ? findedCost.amount : null,
            currency_id: findedCost ? findedCost.currency_id : 3,
          }
      });

      return {
        costs
      }
    },
    computed: {
      ...mapGetters('options', ['currencies']),
    },
    watch: {
      costs: {
        immediate: true,
        handler: function(newVal, prevVal) {
          this.$emit('input', newVal)
        }
      }
    },
    methods: {
      selectCurrency(index, value) {
        this.$set(this.costs[index], 'currency_id', value)
      },
      updateAmount(index, value) {
        this.$set(this.costs[index], 'amount', value)
      }
    },
    async mounted() {
      if(!this.$store.state.options.currencies.length)
          await this.$store.dispatch('options/fetchCurrencies')
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
