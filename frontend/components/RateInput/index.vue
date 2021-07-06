<template>
  <div class="rating">
    <div class="rating__wrap">
      <span>{{ $t('reviews.stars_title') }}</span>
      <div class="review--content-user-desc-rating">
        <ul>
          <li class="stars_one"
              :class="{on: placeholder >= 1 || !placeholder && value >= 1}"
              @mouseover="placeholder = 1"
              @mouseout="placeholder = 0"
              @click="currentValue = 1"
          ></li>
          <li class="stars_two"
              :class="{on: placeholder >= 2 || !placeholder && value >= 2}"
              @mouseover="placeholder = 2"
              @mouseout="placeholder = 0"
              @click="currentValue = 2"
          ></li>
          <li class="stars_tree"
              :class="{on: placeholder >= 3 || !placeholder && value >= 3}"
              @mouseover="placeholder = 3"
              @mouseout="placeholder = 0"
              @click="currentValue = 3"
          ></li>
          <li class="stars_four"
              :class="{on: placeholder >= 4 || !placeholder && value >= 4}"
              @mouseover="placeholder = 4"
              @mouseout="placeholder = 0"
              @click="currentValue = 4"
          ></li>
          <li class="stars_five"
              :class="{on: placeholder >= 5 || !placeholder && value >= 5}"
              @mouseover="placeholder = 5"
              @mouseout="placeholder = 0"
              @click="currentValue = 5"
          ></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  inject: ['$validator'],

  props: {
    value: {
      default: () => null,
    },
    name: {
      default: () => ''
    }
  },

  $_veeValidate: {
    value () {
      return this.currentValue
    },
    name () {
      return this.name;
    }
  },

  data() {
    return {
      currentValue: null,

      placeholder: 0,
    }
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
  border-color: #ebebeb;
  color: rgba(0,0,0,.6);
}
</style>
