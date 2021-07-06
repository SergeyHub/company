<template>
  <transition name="modal">
    <div
      class="modal-window"
      v-show="showModify"
    >
      <div v-show="showClose" @click="close" class="modal-window__close"></div>
      <slot name="default"/>
    </div>
  </transition>
</template>
<script>

import { isMobileDevice } from "../../utils";

export default {
  props: {
    value: {
      type: Boolean,
      default: () => false
    },
    size: {
      type: String,
      default: () => 'sm'
    },
    title: {
      type: String,
      default: () => ''
    },
    /*backButton: {
      type: Boolean,
      default: () => false
    },*/
    showClose: {
      type: Boolean,
      default: () => true
    }
  },
  data() {
    return {
      showModify: this.value,
    }
  },
  watch: {
    showModify(newVal, prevVal) {
      this.$emit('input', newVal);
      if (newVal) {
        //if(isMobileDevice) $('.intercom-app').hide();
        $('body').addClass('is-fixed')
      } else {
        //if(isMobileDevice) $('.intercom-app').show();
        $('body').removeClass('is-fixed')
      }
    },
    value(newVal, prevVal) {
      this.showModify = newVal
    }
  },
  methods: {
    open() {
      this.showModify = true;
      this.$emit('opened')
    },
    close() {
      this.showModify = false;
      this.$emit('closed')
    },
    backButtonClick() {
      this.$emit('backButtonClick')
    }
  }
}
</script>

<style lang="scss" scoped>
@import '~assets/scss/helpers/_all.scss';
@import '~assets/scss/generated/_all.scss';

.modal-window {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1100;
  height: 100vh;
  padding: 50px;
  overflow-y: auto;
  background-color: rgba(0, 0, 0, 0.98);

  &__close {
    position: fixed;
    top: 1px;
    right: 1px;
    z-index: 999;
    width: 80px;
    height: 80px;
    transition: all 0.3s ease;
    background-color: rgba(0, 0, 0, 0.3);
    background-image: url('/files/icons/svg/icon--close.svg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: 24px 24px;
    cursor: pointer;

    @include xs-block() {
      width: 52px;
      height: 52px;
      background-color: #15171a;
      background-size: 16px 16px;
    }

    &:hover {
      background-color: #0d0e10;
    }
  }
}
</style>
