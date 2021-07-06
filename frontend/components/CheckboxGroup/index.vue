<template>
  <div>
    <label class="input-lable">{{ $props.label }}</label>

    <checkbox-input
      v-for="option in options"
      :key="option[valueField]"
      @input="change(option[valueField], $event)"
      :checked="isChecked(option[valueField])"
      :mode="$props.mode"

      :name="label + '/' + option[valueField]"
      :label="option[textField]"
    />
  </div>
</template>
<script>
import CheckboxInput from '~/components/CheckboxInput';

export default {
  props: {
    options: {
      type: Array,
      default: () => []
    },
    mode: {
      type: String,
      default: null
    },
    value: {
      //type: Array,
      default: () => []
    },
    valueField: {
      type: String,
      default: 'id'
    },
    textField: {
      type: String,
      default: 'text'
    },
    label: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      currentValue: []
    }
  },
  components: {
    CheckboxInput
  },

  created() {
    this.currentValue = this.value
  },
  methods: {
    change(option, value) {
      this.currentValue = this.currentValue.filter(item => item !== option)
      if(value == 1) {
        this.currentValue.push(option)
      }
    },
    isChecked(value) {
      if(typeof this.currentValue !== 'object') return false;
      return Object.values(this.currentValue).findIndex(item => item == value) !== -1
    }
  },
  watch: {
    currentValue: {
      deep: true,
      handler(val) {
        this.$emit('input', val)
      }
    }
  }
}
</script>
<style scoped>
span {

}
</style>
