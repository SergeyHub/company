<template>
  <modal
    id="popup__reviews"
    v-model="showModify"
    ref="modal"
  >
    <div class="popup__wrap" v-if="$refs.modal">
      <div class="popup__header">
        <div class="popup__header-title">{{ $t('validation.rejection_reason') }}</div>
      </div>
      <div class="popup__content">
        <div>
          <div>
            <div class="form-group">
              <textarea-multilang
                :key="model.id"
                name="review"
                v-model="form.reason"
                v-validate="'multilang:0,1024'"
                :placeholder="$t('validation.rejection_reason')+'..'"
                :error="errors.first('review')"
              ></textarea-multilang>
            </div>
          </div>
        </div>
      </div>
      <div class="popup__footer mt-30">
        <button
          class="btn btn-submit"
          @click="submit"
        >
          {{ $t('other.continue') }}
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
import Modal from '~/components/Modal'
import TextareaMultilang from '~/components/TextareaMultilang'
import InputMultilang from '~/components/InputMultilang'
import TextInput from '~/components/TextInput'

export default {
  props: {
    value: {
      type: Boolean,
      default: () => false
    }
  },
  components: {
    Modal,
    TextareaMultilang,
    InputMultilang,
    TextInput
  },
  data() {
    return {
      model: {},
      showModify: this.value,
      form: {
        reason: {}
      }
    }
  },
  methods: {
    open(model) {
      this.model = model
      this.showModify = true;
    },
    close() {
      this.showModify = false;
    },
    submit() {
      let reason = { ...this.form.reason }

      this.$store.commit('girls/SET_GIRL', this.model)
      this.$store.dispatch('girls/unverifyGirl', { ...this.model, reason })

      this.close()
    }
  }
}
</script>
