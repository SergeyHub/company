<template>
  <div>
    <AdminUserNav/>
    <div class="admin__wrap">
      <div class="container">
        <h1>{{ $t('profile_nav.girls') }}</h1>

        <div class="row admin__profiles" v-if="current_user !== undefined">
          <div
            v-if="girls.length"
            v-for="(girl, girlIndex) in girls"
            :key="girl.id"
            class="col-3 col-md-3 col-xs-6"
          >
            <div
              v-if="deletedGirls.findIndex(id => id == girl.id) == -1"
              class="admin__profiles-item"
            >
              <div
                :class="{active: girl.status == 'published'}"
                class="admin__profiles-status"
              >
                <span class="xs-hide">{{ $t('girl_statuses.' + girl.status) }}</span>
              </div>
              <div class="admin__profiles-id">
                id: <span>{{ girl.id }}</span>
              </div>
              <div class="admin__profiles-user">
                <div
                  v-lazy:background-image="girl.avatar || asset('/images/default-avatar.png')"
                  class="admin__profiles-user-avatar"
                ></div>

                <div class="admin__profiles-user-title">
                  <div class="admin__profiles-user-name">{{ girl.name || '&puncsp;' }}</div>
                  <div class="admin__profiles-user-type">{{ $t('girl_types.' + girl.type) }}</div>
                  <div class="admin__profiles-user-type" v-if="girl.status == 'published'">
                    <GirlLink :model="girl">
                      Открыть страницу
                    </GirlLink>
                  </div>
                  <div
                    v-if="girl.vip == 0"
                    @click="makeVip(girl)"
                    class="admin__profiles-user-type vip cursor__pointer"
                  >
                    Make vip
                  </div>
                  <div
                    v-else-if="girl.vip == 1"
                    @click="removeVip(girl)"
                    class="admin__profiles-user-type vip cursor__no-drop"
                  >
                    {{ vipMessage(girl) }}
                  </div>
                </div>
              </div>
              <div class="admin__profiles-btn">
                <router-link
                  :to="localePath({ name: 'adminkas-mans-id', params: { id: girl.id }})"
                  class="admin__profiles-btn-item update"
                >
                  {{ $t('girls.edit') }}
                </router-link>
                <div class="admin__profiles-btn-item delet" @click="deleteGirl(girlIndex, girl.id)">{{ $t('girls.delete') }}</div>
              </div>
            </div>
          </div>
          <div v-else>
            No girls
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ModelBlock from '~/components/ModelBlock';
import GirlLink from '~/components/GirlLink'
import { mapGetters } from 'vuex';
import {MessageBox} from "element-ui";
import AdminUserNav from '~/components/AdminUserNav'

export default {
  components: {
    ModelBlock,
    GirlLink,
    AdminUserNav
  },
  computed: {
    ...mapGetters('users', ['current_user']),

    girls() {
      return this.current_user.girls
    }
  },
  data() {
    return {
      deletedGirls: []
    }
  },
  layout: 'admin',
  async asyncData({ store, params }) {
    return await store.dispatch('users/fetchUser', params.id)
  },
  methods: {
    makeVip(girl) {
      MessageBox.prompt('На сколько дней выдать вип?', 'Выдать вип', {
        title: 'Message',
        inputType: 'number',
        inputValue: 365
      })
        .then(({ value }) => {
           return this.$store.dispatch('girls/makeVip', { id: girl.id, days: value })
        })
        .then(res => {
          this.load()
        })
    },
    removeVip(girl) {
      MessageBox.confirm('Обнулить Vip статус?', 'Обнулить вип')
        .then(res => {
          return this.$store.dispatch('girls/removeVip', { id: girl.id })
        })
        .then(res => {
          this.load()
        })
    },
    async load() {
      await this.$store.dispatch('users/fetchUser', this.$route.params.id)
    },
    vipMessage(girl) {
      if(girl.vip_end_date == null) return '';

      return 'VIP (' + this.$t('till') + ' ' + this.$dayjs(girl.vip_end_date).format('YYYY-MM-DD HH:mm') + ')'
    },
    deleteGirl(index, id) {
      MessageBox.confirm(this.$t('girls.delete_girl_warning_text'), this.$t('girls.warning'), {
        confirmButtonText: 'OK',
        cancelButtonText: this.$t('girls.cancel'),
        type: 'warning'
      }).then(() => {
        this.$store.dispatch('girls/deleteGirl', id)
        .then(() => {
          this.deletedGirls.push(id)
        })
      });
    }
  }
}
</script>
