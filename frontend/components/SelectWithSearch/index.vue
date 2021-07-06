<template>
  <no-ssr>
    <div :class="{
      inputContainer: required,
      'is-valid': !error && validating && currentValue,
      'is-invalid': error && validating,
      'required': required}"
    >
      <multiselect
        :class="{
          multiselect__profile: mode == 'profile',
          multiselect__filter: mode == 'filter'
      }"
        v-model="currentValue"
        :selectLabel="''"

        :track-by="valueField"
        :label="textField"
        :placeholder="placeholder"
        :options="options"
        :searchable="searchable"
        :allow-empty="!required"
      />

      <input
        type="hidden"
        v-model="currentValue"
        :name="name"
      >
     </div>
  </no-ssr>
</template>

<script>
export default {
  inject: ['$validator'],

  props: {
    placeholder: {
      type: String,
      default: ''
    },
    mode: {
      type: String,
      default: 'profile'
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

      handledOptions: [],
      ready: false,
    }
  },
  created() {
    this.handledOptions = this.$props.options.map(option => ({
      id: option[this.$props.valueField],
      text: option[this.$props.textField]
    }));

    this.ready = true
  },
  mounted() {
    this.currentValue = this.value;

    let index = this.options.findIndex(item => item[this.valueField] == this.$props.value)

    if(index !== -1) this.currentValue = this.options[index]
  },

  watch: {
    currentValue: {
      deep: true,
      handler(newVal, prevVal) {
        let val = typeof newVal !== 'object' ? newVal : newVal[this.$props.valueField]
        this.$emit('input', val)
      }
    },
    value: {
      deep: true,
      handler(newVal) {
        if(newVal == '') {
          this.currentValue = null
          return
        }
        let index = this.options.findIndex(item => item[this.valueField] == newVal)

        if(index !== -1) this.currentValue = this.options[index]
      }
    },
    options: {
      deep: true,
      handler(options) {
        let index = this.options.findIndex(item => item[this.valueField] == this.$props.value)

        if(index !== -1) this.currentValue = this.options[index]
      }
    }
  },

}
</script>
<style lang="scss">
.multiselect__filter {
  //border: 1px solid hsla(0,0%,100%,.3);

  min-height: 34px;

  .multiselect__input, .multiselect__single {
    line-height: 24px;
  }

  .multiselect__tags {
    padding-top: 4px !important;
    max-height: 34px !important;
    min-height: 34px !important;
  }

  &__input, &__single {
    color: hsla(0,0%,100%,.6);
  }

  .multiselect__current, .multiselect__select {
    //line-height: 8px;
    height: 34px;
  }

  &__input, &__single {
    color: hsla(0,0%,100%,.6);
  }
}

.multiselect__profile {
  .multiselect__input, .multiselect__single {
    line-height: 30px;
  }

  .multiselect__tags {
    max-height: 50px;
    min-height: 50px;
    line-height: 21px;
  }
}

.admin__profile-item {
  .multiselect__tags {
    border-color: #191919 !important;
  }
}

.multiselect {
  //border-color: #191919;

  & input::-webkit-input-placeholder { /* Chrome */
    color: hsla(0,0%,100%,.6);
  }
  & input:-ms-input-placeholder { /* IE 10+ */
    color: hsla(0,0%,100%,.6);
  }
  & input::-moz-placeholder { /* Firefox 19+ */
    color: hsla(0,0%,100%,.6);
  }
  & input:-moz-placeholder { /* Firefox 4 - 18 */
    color: hsla(0,0%,100%,.6);
  }

  &__tags, &__single, &__input {
    background-color: rgba(1,1,1,0) !important;
  }
  &__input, &__single {
    color: white !important;
  }

  &__select {
    height: 50px;
  }

  &__content-wrapper {
    border-color: #191919;
    border-top: 1px solid #191919 !important;
  }

  &__element {
    background: black;
    color: rgb(133,133,133);
  }

  &__tags {
    border-radius: 0 !important;
    border-color: rgba(255, 255, 255, 0.3);
  }

  &__input {
    padding: 0 !important;
    height: 16px !important;
  }

  &__option--highlight, &__option--highlight:after, &__tag {
    background-color: #ffbc3f !important;
    color: rgb(43, 45, 51) !important;
  }
}

</style>
