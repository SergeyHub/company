<template>
  <no-ssr>
    <div :class="{ inputContainer: required, 'is-valid': !error && validating && currentValue, 'is-invalid': error && validating, 'required': required}">
      <!--<select2
        class="select"
        v-validate="$props.validate"
        :id="name"
        :width="'100%'"
        v-model="currentValue"
        :options="handledOptions"
        :settings="settings"
        :aria-describedby="'input-'+name+'-live-feedback'"
        :name="name"
        :placeholder="placeholder"
      ></select2>-->
      <multiselect
        v-model="currentValue"

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

      <!-- <div class="invalid-feedback">
         {{ errors.first(name) }}
       </div>-->

      <!--<b-form-invalid-feedback :id="'input-'+name+'-live-feedback'" :class="error ? 'got-error' : ''" >
          {{ error }}
        </b-form-invalid-feedback>-->
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
.multiselect {
  //border-color: #191919;

  &__tags, &__single, &__input {
    background-color: rgba(1,1,1,0) !important;
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
    max-height: 40px;
    line-height: 21px;
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
/*
.multiselect {
  &__select {
    height: 40px;
  }

  &__tags {
    padding-top: 0;
  }
}*/
</style>
