<template>
  <div class="checkbox" v-if="$props.mode == 'popup'">
    <div class="checkbox__wrap">
      <input
        type="checkbox"
        :id="name"
        :name="name"
        v-model="value"
      />
      <label :for="name"></label>
    </div>
    <label :for="name"><span>{{ label }}</span></label>
  </div>
  <div class="admin__profile-checkbox" v-else>
    <input
      :id="name"
      type="checkbox"
      :name="name"
      v-model="value"
    />
    <label :for="name" class="checkbox-box"></label>
    <label :for="name">{{ label }}</label>
  </div>
</template>
<script>
export default {
  props: {
    checked: {
      type: Boolean,
      default: false
    },
    name: {
      type: String
    },
    label: {
      type: String
    },
    mode: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      value: false
    }
  },
  created() {
    this.value = this.$props.checked
  },
  watch: {
    value(newVal, prevVal) {
      this.$emit('input', newVal ? 1 : 0)
    }
  }
}
</script>
<style scoped>
.checkbox-box {
  margin-right: 10px !important;
}

input[type=checkbox] {
  padding: 0 !important;
}
</style>
