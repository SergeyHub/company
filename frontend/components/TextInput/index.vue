<template>
  <input
    v-if="mode == 'profile'"
    class="input"
    :type="type"
    v-model="currentValue"
    :placeholder="placeholder"
    :name="name"
    :disabled="disabled"
  >

  <input
    v-else-if="mode == 'filter'"
    class="filter__input"
    :type="type"
    v-model="currentValue"
    :placeholder="placeholder"
    :name="name"
    :disabled="disabled"
  >
</template>

<script>
export default {
  inject: ['$validator'],

  props: {
    placeholder: {},
    mode: {
      default: 'profile'
    },
    label: {
      default: ''
    },
    value: {
      default: () => null,
    },
    options: {
      type: Array,
      default: () => []
    },
    state: {
      default: () => null,
    },
    name: {
      type: String,
      required: false,
    },
    error: {
      type: String,
      //  required: false,
      default: () => null,
    },
    validating: {
      type: Boolean,
      default: () => false
    },
    required: {
      type: Boolean,
      default: () => true
    },
    textField: {
      type: String,
      default: 'text'
    },
    valueField: {
      type: String,
      default: 'id'
    },
    searchable: {
      type: Boolean,
      default: true
    },
    type: {
      type: String,
      default: 'text'
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },

  $_veeValidate: {
    value () {
      return this.currentValue
    },
    name () {
      return this.name;
    },
    events: 'input'
  },

  data() {
    return {
      currentValue: null,

      ready: false,
    }
  },
  created() {
    this.ready = true
  },
  mounted() {
    this.currentValue = this.$props.value;
  },

  watch: {
    currentValue: {
      deep: true,
      handler(newVal, prevVal) {
        this.$emit('input', newVal)
        this.currentValue = newVal
      }
    },
    value: {
      deep: true,
      handler(newVal) {
        this.currentValue = newVal
      }
    }
  },

}
</script>
