<template>
  <div :class="{ inputContainer: required, 'is-valid': !error && validating && currentValue, 'is-invalid': error && validating, 'required': required}">
    <select
      class="select"
      autocomplete="off"
      :id="name"
      v-model="currentValue"
      :name="name"
    >
      <option
        value=""
        disabled
        hidden
        v-if="placeholder"
        ref="placeholder"
      >{{ placeholder }}</option>
      <option
        style="background-color: black;"
        v-for="option in handledOptions"
        :key="option.id"
        :value="option.id"
      >{{ option.text }}</option>
    </select>
  </div>
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
      //  required: true,
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
    events: 'change'
  },

  data() {
    return {
      currentValue: null,

      ready: false,
    }
  },
  computed: {
    handledOptions() {
      return  this.$props.options.map(option => ({
        id: option[this.$props.valueField],
        text: option[this.$props.textField]
      }));
    }
  },
  created() {
    this.ready = true
  },
  mounted() {
    this.currentValue = this.value;
    if(this.$refs.placeholder) this.$refs.placeholder.selected = true
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
<style lang="scss" scoped>
.select {
  background-color: rgba(1,1,1,0.01);
  position: relative;

  &:before {
    content: url('/files/icons/svg/icon--filter-arrow.svg');
    position: absolute;
    top: 50%;
    right: 15px;
    width: 16px;
    height: 16px;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
  }
}

</style>
