<template>
  <modal
    v-model="showModify"
    :title="$t('public_profile.fake_report')"
    id="popup__one"
  >
    <div class="popup__wrap">
      <div class="popup__header">
        <div class="popup__header-title">
          {{ $t('public_profile.send_report_on') }} {{current_girl.name}}
        </div>
      </div>
      <div class="popup__content">
        <div class="col-12">
          <div class="admin__profile-input">
            <TextInput
              :name="'name'"
              v-model="form.name"
              required
              :placeholder="$t('public_profile.your_name')"
              v-validate="{ required: true }"
            />
            <div class="invalid-feedback">
              {{ errors.first('name') }}
            </div>
          </div>
          <div class="admin__profile-input">
            <TextInput
              :name="'email'"
              v-model="form.email"
              v-validate="{ required: true, email: true }"
              :placeholder="$t('public_profile.your_email')"
            />
            <div class="invalid-feedback">
              {{ errors.first('email') }}
            </div>
          </div>
          <div class="admin__profile-input">
            <TextareaInput
              :name="'content'"
              v-model="form.report"
              required
              :placeholder="$t('public_profile.your_report')"
              rows="4"
              style="height: 135px;"
              v-validate="{required: true}"
            ></TextareaInput>
            <div class="invalid-feedback">
              {{ errors.first('content') }}
            </div>
          </div>
        </div>
      </div>
      <div class="popup__footer">
        <AppButton mode="custom" @click.native="sendFakeReport" class="btn btn-accent">{{$t('public_profile.send_fake_report')}}</AppButton>
      </div>
    </div>
  </modal>
</template>

<script>
  import Modal from '~/components/Modal'
  import AppButton from '~/components/AppButton'
  import TextInput from '~/components/TextInput'
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
      AppButton,
      TextInput,
      TextareaInput
    },
    data() {
      return {
        showModify: this.value,
        form: {},
      }
    },
    head() {
      let canonical = 'https://' + process.env.base_domain + (this.$route.path === '/' ? '' : this.$route.path.replace(/\/*$/, '/') )
      return {
        link: [
          { rel: 'canonical', href: canonical }
        ]
      }
    },
    computed: {
      ...mapGetters('girls', ['current_girl']),
    },
    methods: {
      open() {
        this.showModify = true;
      },
      close() {
        this.showModify = false;
      },
      sendFakeReport() {
        let data = this.form;
        data.girl = this.$route.params.id;
        this.$store.dispatch('girls/sendFakeReport', data)
          .then(() => {
            Message.success(this.$t('public_profile.fake_report_sended'));
            this.close();
            this.form = {};
          });
      }
    }
  }
</script>

<style>
  .fake-modal input.form-control{
    height: calc(2.0125rem + 2px);
    margin-top: 1rem;
  }
  .fake-modal textarea {
    margin-top: 1rem;
  }
</style>
