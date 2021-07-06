<template>
  <textarea
    v-model="currentValue"
    :placeholder="placeholder"
    :name="name"
  ></textarea>
</template>

<script>
export default {
  inject: ['$validator'],

  props: {
    placeholder: {},
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
<style type="scss" scoped>
input {
  width: 100%;
  border-color: #ebebeb !important;
  color: rgba(0,0,0,.6) !important;
}
</style>
