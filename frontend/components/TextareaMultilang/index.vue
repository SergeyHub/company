<template>
  <div class="admin__profile-textarea">
    <textarea
      class="textarea"
      v-model="currentValue[locale]"
      :placeholder="placeholder"
      :state="state"
      :rows="rows"
      ref="el"
      max-rows="8"
      :name="name"
      :id="name"
      :aria-describedby="'input-'+name+'-live-feedback'"
    ></textarea>
    <div class="field__lang">
      <div
        v-for="locale in availableLocales"
        :key="locale.code"
        @click="selectLocale(locale)"
        class="field__lang-item"
        :class="{active: currentLocale == locale}"
      >
        <img :src="cdn_assets + locale.image">
      </div>
    </div>
    <div class="invalid-feedback">
      {{ error }}
    </div>
  </div>
</template>

<script>
export default {
  inject: ['$validator'],

  props: {
    value: {
      type: Object,
      default: () => Object.assign({}, {'en': '', 'ru': ''})
    },
    state: {
      default: () => null,
    },
    rows: {
      type: Number,
      default: () => 5,
    },
    label: {
      type: String,
      default: () => ''
    },
    name: {
      type: String,
      required: true,
    },
    placeholder: {
      type: String,
      default: () => ''
    },
    error: {
      type: String,
      required: false
    },
    required: {
      type: Boolean,
      default: () => true
    }
  },

  $_veeValidate: {
    value () {
      return this.currentValue//[this.locale]
    },
    name () {
      return this.name;
    },
    events: 'input'
  },

  data() {
    return {
      cdn_assets: process.env.cdn_assets,
      currentLocale: this.$i18n.locales.filter(el => el.code === this.$i18n.locale)[0],
      locale: this.$i18n.locale,
      currentValue: this.value,
    }
  },

  computed: {
    availableLocales() {
      return this.$i18n.locales//.filter(locale => locale.code !== this.currentLocale.code);
    },
  },

  watch: {
    currentValue: {
      deep: true,
      handler(newVal, prevVal) {
        this.$emit('input', newVal)
        this.$emit('localeValue', newVal[this.locale])
      }
    }
  },

  methods: {
    selectLocale(locale) {
      this.currentLocale = locale;
      this.locale = locale.code;
    }
  }

}
</script>

<style lang="scss">
.multilang-textarea {
  position: relative;

  textarea {
    padding-right: 120px !important;
  }

  &.dark textarea {
    border: 0 !important;
    border-radius: 3px;
    background-color: transparent;
    color: white;
    font-size: 16px !important;
    line-height: 150%;
    min-height: 200px;
  }
}
.select-lang-textarea {
  position: absolute;
  top: 3px;
  right: 3px;
  display: flex;
  flex-direction: row;

  .dropdown-toggle {
    padding: 5px 10px;
    font-size: 13px;
    background: #fff;
    color: #000;
    border: 1px solid #F1F2F6;
  }
  .lang {
    transition: 0.3s all;
    background-color: rgb(158, 164, 171);
    padding: 6px;
    cursor: pointer;

    &.active, &:hover {
      background-color: rgb(88, 94, 101);
    }
    border-radius: 3px;

    &:first-child {
      border-radius: 3px 0 0 3px;
    }

    &:last-child {
      border-radius: 0 3px 3px 0;
    }
  }
  img {
    height: 25px;
  }
}
</style>
