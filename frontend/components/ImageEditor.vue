<template>
  <modal v-model="show" size="lg" title="Замазка фотографии">
    <div class="imageEditorApp" style="height: 600px" v-if="show" v-loading="loading">
      <image-editor style="height: 600px" ref="tuiImageEditor"
                    :include-ui="useDefaultUI"
                    :options="options">
      </image-editor>
    </div>
    <template slot="footer">
      <AppButton variant="primary"
                @click="save"
                v-loading="buttonLoading">
        Сохранить
      </AppButton>
    </template>
  </modal>
</template>

<script>
  import Modal from '~/components/Modal'
  //import BButton from "bootstrap-vue/src/components/button/button";
  import AppButton from '~/components/AppButton'
  import { mapGetters } from 'vuex'

  const icona = require('tui-image-editor/dist/svg/icon-a.svg');
  const iconb = require('tui-image-editor/dist/svg/icon-b.svg');
  const iconc = require('tui-image-editor/dist/svg/icon-c.svg');
  const icond = require('tui-image-editor/dist/svg/icon-d.svg');

  //const bg = require('tui-image-editor/examples/img/bg.png')
  var blackTheme = { // or white
    // main icons
    'menu.normalIcon.path': icond,
    'menu.activeIcon.path': iconb,
    'menu.disabledIcon.path': icona,
    'menu.hoverIcon.path': iconc,
    'submenu.normalIcon.path': icond,
    'submenu.activeIcon.path': iconc,
  }

  export default {
    components: {
      AppButton,
      Modal
    },

    computed: {
      ...mapGetters('girls', ['current_girl'])
    },

    data() {
      return {
        useDefaultUI: true,
        options: {
          includeUI: {
            theme: blackTheme,
            loadImage: {
              path: '/img/logo.png',
              name: 'SampleImage'
            },
          },
          cssMaxWidth: 700,
          cssMaxHeight: 600
        },
        photo: null,
        show: false,
        loading: true,
        buttonLoading: false,
      }
    },

    methods: {
      open(photo) {
        this.options.includeUI.loadImage = {
           path: photo + '?t='+Date.now(),
           name: 'SampleImage'
        };
        this.loading = true;
        this.show = true;
        setTimeout(() => {
          this.loading = false
        }, 1500);
        this.$nextTick(() => {
          let tui_header = document.querySelector('.tui-image-editor-header');
          if(tui_header)
            tui_header.remove()
        });
      },

      save() {
        this.buttonLoading = true;
        const image = this.$refs.tuiImageEditor.editorInstance.toDataURL();
        this.$store.dispatch('girls/uploadHiddenPhoto', {id: this.current_girl.id, image: image})
          .then((response) => {
            this.buttonLoading = false;
            this.show = false;
            this.$emit('uploaded', response)
          })
          .catch(() => {
            this.buttonLoading = false;
          })
      }
    },
  }
</script>
