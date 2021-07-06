<template>
  <modal v-model="show" :show-close="false" class="attention">
    <div class="attention__overlay"></div>
    <div class="attention__wrap">
      <div class="attention__head">
        <div class="attention__head-logo"><img src="/files/icons/svg/logo.svg" alt=""></div>
        <div class="attention__head-title">18+</div>
        <div class="attention__head-content">
          <p>{{ $t('agree_modal.title') }}</p>
        </div>
      </div>
      <div class="attention__footer">
        <div class="attention__footer-btn">
          <a href="https://google.ru" class="btn btn-nofocus">{{ $t('agree_modal.not_agree') }}</a>
          <AppButton class="attention_yes btn btn-icon" @click.native="agree">
            <svg><use xlink:href="/files/sprite.svg#icon--check"/></svg>
            <span>{{ $t('agree_modal.agree') }}</span>
          </AppButton>
        </div>
        <a
          to="/terms"
          target="_blank"
          class="privacy"
        >
          {{ $t('agree_modal.terms') }}
        </a>
      </div>
    </div>
  </modal>
  <!--
  <template slot="header">
      <b-dropdown right class="lang-dropdown lang-dropdown-small">
        <template slot="button-content">
          <img v-bind:src="cdn_assets + currentLocale.image">
          <i class="fas fa-caret-down"></i>
        </template>
        <b-dropdown-item v-for="locale in availableLocales"
                         :key="locale.code"
                         :href="switchLocalePath(locale.code)"
                         @click.prevent="$router.push(switchLocalePath(locale.code))">
          <img v-bind:src="cdn_assets + locale.image">
          {{ locale.name }}
        </b-dropdown-item>
      </b-dropdown>
    </template>
    <content-block slug="agree_18"/>
    <template slot="footer">
      <b-button variant="primary" @click="agree">
        {{ $t('agree_modal.agree') }}
      </b-button>
      <a href="https://google.com" class="mt-3">
        {{ $t('agree_modal.not_agree') }}
      </a>
    </template>

  -->
</template>

<script>
  import Modal from '~/components/Modal'
  import ContentBlock from '~/components/ContentBlock'
  import Cookie from 'js-cookie'
  import AppButton from '~/components/AppButton'

  export default {
    components: {
      Modal,
      ContentBlock,
      AppButton
    },
    computed: {
      availableLocales() {
        return this.$i18n.locales.filter(i => i.code !== this.$i18n.locale)
      },

      currentLocale() {
        return this.$i18n.locales.filter(i => i.code === this.$i18n.locale)[0]
      },
    },
    data() {
      return {
        show: true,
        cdn_assets: process.env.cdn_assets
      }
    },
    methods: {
      agree() {
        this.show = false;
        var current_domain = '.' + process.env.base_domain;
        Cookie.set('18_showed', '1', {path: '', domain: current_domain, expires: 1440 });
      }
    }
  }
</script>

<style lang="scss">
  .lang-dropdown-small {
    position: absolute;
    right: 0;
    top: 0;
    width: 50px;
    img {
      height: 26px;
    }
    .dropdown-toggle {
      padding: 0;
      border-radius: 0!important;
      i {
        color: #eee;
      }
    }
  }
</style>
