<template>
  <div class="multilang-input">
      <b-form-group
        :label="label"
        label-size="sm"
      >
        <div :class="required ? 'inputContainer required' : ''">
          <b-form-input
            type="text"
            v-model="currentValue[locale]"
            :state="state"
            :aria-describedby="'input-'+name+'-live-feedback'"
          ></b-form-input>
          <b-form-invalid-feedback :id="'input-'+name+'-live-feedback'" v-show="error">
            {{ error }}
          </b-form-invalid-feedback>
          <div class="select-lang-textarea">
            <b-dropdown class="lang-textarea-dropdown">
              <template slot="button-content">
                <img v-bind:src="cdn_assets + currentLocale.image">
                {{ currentLocale.name }}
              </template>
              <b-dropdown-item v-for="locale in availableLocales" :key="locale.code" @click="selectLocale(locale)">
                <img v-bind:src="cdn_assets + locale.image">
                {{ locale.name }}
              </b-dropdown-item>
            </b-dropdown>
          </div>
        </div>
      </b-form-group>
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
      label: {
        type: String,
        default: () => ''
      },
      name: {
        type: String,
        required: true,
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
        return this.value[this.locale]
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
        return this.$i18n.locales.filter(locale => locale.code !== this.currentLocale.code);
      },
    },

    watch: {
      value: {
        deep: true,
        handler(newVal, prevVal) {
//          this.currentValue = _.clone(newVal)
        }
      },
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
  .multilang-input input {
    padding-right: 120px!important;
  }
  .select-lang-textarea {
    position: absolute;
    top: 3px;
    right: 3px;
    .dropdown-toggle {
      padding: 5px 10px;
      font-size: 13px;
      background: #fff;
      color: #000;
      border: 1px solid #F1F2F6;
    }
    img {
      height: 20px;
      margin-right: 5px;
    }
  }
</style>
