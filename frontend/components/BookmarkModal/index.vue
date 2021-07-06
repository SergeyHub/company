<template>
  <modal
    id="popup__reviews"
    v-model="showModify"
    ref="modal"
  >
    <div class="popup__wrap" v-if="$refs.modal">
      <div class="popup__header">
        <div class="popup__header-title">{{ $t('public_profile.write_bookmark') }}</div>
      </div>
      <div class="popup__content">
        <div>
          <div>
            <div class="form-group">
              <textarea-input
                class="dark"
                name="review"
                v-model="form.content"
                :placeholder="$t('public_profile.write_bookmark')+'..'"
                v-validate="'required'"
              ></textarea-input>

              <div class="invalid-feedback">
                {{ errors.first('bookmark') }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="popup__footer mt-30">
        <button
          class="btn btn-submit"
          @click="setBookmark"
        >
          {{ $t('public_profile.save_bookmark') }}
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
import Modal from '~/components/Modal'
import TextareaInput from '~/components/TextareaInput'
import {mapGetters} from "vuex";
import {Message} from "element-ui";

export default {
  props: {
    value: {
      type: Boolean,
      default: () => false
    }
  },
  components: {
    Modal,
    TextareaInput
  },
  data() {
    return {
      showModify: this.value,
      form: {}
    }
  },
  computed: {
    ...mapGetters('girls', ['current_girl']),
    ...mapGetters('auth', ['isAuthentificated']),
  },
  methods: {
    open() {
      if(!this.isAuthentificated) {
        return this.$router.push(this.localePath('login'))
      }
      this.showModify = true;
    },
    close() {
      this.showModify = false;
    },
    setBookmark() {
      if(!this.isAuthentificated) {
        return this.$router.push(this.localePath('login'))
      }
      this.$validator.validateAll().then(result => {
        if (!result)
          return;

        let data = this.form;
        data.girl_id = this.current_girl.id;
        this.$store.dispatch('girls/setBookmark', data)
          .then((res) => {
            if(res.success) {
              Message.success(this.$t('public_profile.bookmark_saved'));
            }
            this.close();
          });
      })
    }
  }
}
</script>
