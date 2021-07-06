<template>
  <div>
    <AdminUserNav/>
    <div class="admin__wrap">
      <div class="container" v-if="current_user">
        <h1>{{ $t('settings.title') }}</h1>

        <div class="row admin__profile">

          <div class="col-6 col-md-6 col-xs-12">
            <div class="admin__profile-item">
              <label
                class="input-lable"
                for="email"
              >{{ $t('settings.email') }}:</label>
              <div class="admin__profile-input">
                <text-input
                  id="email"
                  v-model="form.email"
                  name="email"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-md-12 col-xs-12 mt-10">
            <checkbox-input
              name="notifications"
              :checked="form.receive_notifications == 1"
              :label="$t('profile.receive_notifications')"
              v-model="form.receive_notifications"
            />
          </div>
          <div class="col-12 col-md-12">
            <hr>
          </div>
          <div class="col-3 col-md-3 col-xs-12 mb-20">
            <div class="admin__profile-item">
              <label
                :title="$t('settings.password_tooltip')"
                class="input-lable"
                for="new_password"
              >{{ $t('settings.new_password') }}</label>
              <div class="admin__profile-input">
                <text-input
                  name="new_password"
                  type="new_password"
                  v-model="form.password"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-md-12 col-xs-12">
            <button class="btn btn-border" @click="sendForm">{{ $t('profile.save') }}</button>
          </div>
          <div class="col-12 col-md-12">
            <hr>
          </div>
          <div class="col-12 col-md-12 col-xs-12">
            <button class="btn btn-border" @click="banUser" v-if="current_user.deleted_at == null">{{ $t('adminkas.ban') }}</button>
            <button class="btn btn-border" @click="unbanUser" v-else>{{ $t('adminkas.unban') }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
import { Message } from 'element-ui'
import TextInput from '~/components/TextInput'
import CheckboxInput from '~/components/CheckboxInput'
import AdminUserNav from '~/components/AdminUserNav'

export default {
  components: {
    TextInput,
    CheckboxInput,
    AdminUserNav
  },

  computed: {
    ...mapGetters('users', ['current_user'])
  },

  data() {
    return {
      form: {},
    }
  },
  layout: 'admin',
  async asyncData({ store, params }) {
    return store.dispatch('users/fetchUser', params.id)
      .then((data) => {
        return {
          form: _.cloneDeep(data.data)
        }
      })
  },

  methods: {
    validateState(ref) {
      if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
        return !this.errors.has(ref)
      }
      return null
    },

    sendForm() {
      this.$validator.validateAll().then(result => {
        if(!result)
          return;

        this.$store.dispatch('users/updateUser', this.form)
          .then(() => {
            Message.success(this.$t('settings.success_update'));
          })
      });
    },
    banUser() {
      this.$store.dispatch('users/banUser', this.current_user.id)
        .then(() => {
          Message.success(this.$t('adminkas.user_banned'));
        })
    },
    unbanUser() {
      this.$store.dispatch('users/unbanUser', this.current_user.id)
        .then(() => {
          Message.success(this.$t('adminkas.user_unbanned'));
        })
    }
  }
}
</script>
