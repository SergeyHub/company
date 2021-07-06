<template>
  <b-form-group
    label-cols-sm="4"
    :label="label"
    label-align-sm="right"
    label-for="nested-street"
    label-size="sm"
  >
    <div class="inputContainer" :class="{required: required}">
      <b-row>
        <b-col :cols="tooltip ? 10 : 12" :class="{input_with_tooltip: tooltip}">
          <b-form-input
            id="nested-street"
            v-model="customValue"
            :state="state"
            v-validate="validate"
            :aria-describedby="'input-'+name+'-live-feedback'"
            :name="name"
            size="sm">
          </b-form-input>
          <b-form-invalid-feedback :id="'input-'+name+'-live-feedback'">
            {{ error }}
          </b-form-invalid-feedback>
        </b-col>
        <b-col cols="2" class="question_block" v-if="tooltip">
          <i class="far fa-question-circle" v-b-tooltip.hover :title="tooltipText"></i>
        </b-col>
      </b-row>
    </div>
  </b-form-group>
</template>

<script>
  export default {
    props: {
      value: {
        type: String,
        default: () => '',
      },
      name: {
        type: String,
        default: () => '',
      },
      label: {
        type: String,
        default: () => '',
      },
      required: {
        type: Boolean,
        default: () => false,
      },
      placeholder: {
        type: String,
        default: () => '',
      },
      tooltip: {
        type: Boolean,
        default: () => false
      },
      tooltipText: {
        type: String,
        default: () => ''
      },
      state: {
        default: () => null
      },
      error: {
        type: String,
        default: () => '',
      },
      validate: {
        type: Object,
        default: () => {required: false}
      }
    },
    data() {
      return {
        customValue: this.value,
      }
    },
    watch: {
      value(newValue, prevValue) {
        this.customValue = newValue;
      },
      customValue(newValue, prevValue) {
        this.$emit('input', newValue)
      }
    }

  }
</script>

<style>
  .input_with_tooltip {
    padding-right: 10px;
  }
  .question_block {
    padding: 0;
    margin: 0;
  }
  .question_block i {
    font-size: 21px;
    line-height: 37px;
    color: #fa6b6b;
  }
</style>
