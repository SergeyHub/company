<template>
  <modal ref="modal" id="popup__one">
    <div class="popup__wrap">
      <div class="popup__header">
        <div class="popup__header-title">{{ $t('chat.create_offer') }}</div>
      </div>
      <div class="popup__content">
        <form @submit.prevent="sendMessage">
          <checkbox-input
            v-model="showMeetingDateSelector"
            :label="$t('public_profile.know_meeting_date')"
            mode="popup"
            name="show_meeting_date_selector"/>
          <!--<label for="show_meeting_date_selector">{{ $t('public_profile.know_meeting_date') }}</label>-->
          <div
            class="input__datetime admin__profile-input"
            v-show="showMeetingDateSelector"
          >
            <date-picker
              class="dark input"
              v-model="form.meeting_date"
              format="yyyy.MM.dd"
              type="date"
              :placeholder="$t('public_profile.select_meeting_date')"
            ></date-picker>
          </div>

          <!--<checkbox-input
            name="want_manager_recall"
            :label="$t('public_profile.want_manager_recall')"
            mode="popup"
            v-model="form.want_manager_recall"
          />-->

          <div class="form-group admin__profile-input">
            <text-input
              name="phone"
              :value="form.phone"
              @input="updatePhone"
              v-validate="{ required: true }"
              mode="profile"
              :placeholder="$t('public_profile.contact_phone')"
            />

            <div class="invalid-feedback">
              {{ errors.first('phone') }}
            </div>
          </div>
          <div class="form-group">
            <textarea-input
              name="content"
              :placeholder="$t('dialogs.write_message')"
              v-validate="'max:1024|required'"
              v-model="form.content"
            />
            <div class="invalid-feedback">
              {{ errors.first('content') }}
            </div>
          </div>
        </form>
      </div>
      <div class="popup__footer">
        <button class="btn btn__submit" @click="sendMessage">{{ $t('public_profile.send') }}</button>
      </div>
    </div>
  </modal>
</template>
<script>
import Modal from '~/components/Modal'
import { mapGetters } from 'vuex'
import { Message } from 'element-ui'
import TextInput from '~/components/TextInput';
import CheckboxInput from '~/components/CheckboxInput';
import TextareaInput from '~/components/TextareaInput';

export default {
  components: {
    Modal,
    TextInput,
    CheckboxInput,
    TextareaInput
  },
  computed: {
    ...mapGetters('auth', ['isAuthentificated', 'loggedUser']),
    ...mapGetters('girls', ['current_girl']),
    ...mapGetters('profile', ['client_profile'])
  },
  data() {
    return {
      form: {
        phone: ''
      },
      showMeetingDateSelector: false
    }
  },
  created() {
    if(this.isAuthentificated && this.client_profile && this.client_profile.phone) {
      this.updatePhone(this.client_profile.phone)
    }
  },
  methods: {
    open() {
      this.$refs.modal.open()
    },
    close() {
      this.$refs.modal.close()
    },
    updatePhone(phone) {
      this.$set(this.form, 'phone', typeof phone == 'string' && phone.length ? '+' + phone.replace(/[^0-9]/g , '') : '');
    },
    sendMessage() {
      this.$validator.validateAll().then(result => {
        if (!result) {
          return;
        }

        /* if (!this.isAuthentificated) {
           return this.$router.push(this.localePath('login'))
         }*/

        let params = {
          user_to: this.current_girl.user_id,
          girl_id: this.current_girl.id,
          ...this.form,
        }

        this.$store.dispatch('girls/sendClientApplication', params)
          .then(result => {
            Message.success(this.$t('public_profile.application_sended'))
            this.close()
          })
          .catch(result => {
            Message.error(this.$t('public_profile.error_occured'))
          })
      })
    }
  }
}
</script>
