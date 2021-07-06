<template>
  <div class="editor-multilang">
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
    <div class="quill-editor"
         :content="currentValue[locale]"
         @change="onEditorChange($event)"
         v-quill:myQuillEditor="editorOption">
    </div>
  </div>
</template>

<script>
  export default {

    props: {
      value: {
        type: Object,
        default: () => Object.assign({}, {'en': '', 'ru': ''})
      },
    },

    data () {
      return {
        cdn_assets: process.env.cdn_assets,
        currentLocale: this.$i18n.locales.filter(el => el.code === this.$i18n.locale)[0],
        locale: this.$i18n.locale,
        currentValue: this.value,
        editorOption: {
          // some quill options
          modules: {
            toolbar: [
              ['bold', 'italic', 'underline', 'strike'],
              ['blockquote', 'code-block'],
              [{ 'header': 1 }, { 'header': 2 }],
              [{ 'list': 'ordered' }, { 'list': 'bullet' }],
              [{ 'script': 'sub' }, { 'script': 'super' }],
              [{ 'indent': '-1' }, { 'indent': '+1' }],
              [{ 'direction': 'rtl' }],
              [{ 'size': ['small', false, 'large', 'huge'] }],
              [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
              [{ 'font': [] }],
              [{ 'color': [] }, { 'background': [] }],
              [{ 'align': [] }],
              ['clean'],
              ['link', 'image', 'video', 'code']
            ],
          }
        }
      }
    },

    computed: {
      availableLocales() {
        return this.$i18n.locales.filter(locale => locale.code !== this.currentLocale.code);
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
      onEditorChange({ editor, html, text }) {
        this.currentValue[this.locale] = html
      },
      selectLocale(locale) {
        this.currentLocale = locale;
        this.locale = locale.code;
      }
    }
  }
</script>

<style lang="scss" scoped>
  .editor-multilang {
    margin: 20px 0;
  }
  .select-lang-textarea {
    position: absolute;
    top: 15px;
    right: 15px;
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
