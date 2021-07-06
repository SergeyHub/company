<template>
  <div class="admin__wrap">
    <div class="container">
      <h1>{{ $t('profile.profiles_title') }}</h1>

      <div class="row admin__profiles">
        <div
          v-for="(girl, girlIndex) in girls"
          :key="girl.id"
          class="col-3 col-md-3 col-xs-6"
        >
          <div class="admin__profiles-item">
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
                <div class="admin__profiles-user-type vip" v-if="girl.vip == 1">
                  {{ vipMessage(girl) }}
                </div>
              </div>
            </div>
            <div class="admin__profiles-btn">
              <router-link
                :to="localePath({ name: 'profile-id', params: { id: girl.id }})"
                class="admin__profiles-btn-item update"
              >
                {{ $t('girls.edit') }}
              </router-link>
              <div class="admin__profiles-btn-item delet" @click="deleteGirl(girlIndex, girl.id)">{{ $t('girls.delete') }}</div>
            </div>
          </div>
        </div>
        <div
          class="col-3 col-md-3 col-xs-6"
          @click="$refs.select_girl_type.open()"
        >
          <a href="#" class="admin__profiles-item add">
            <img :src="cdn_assets_prefix + '/files/icons/svg/icon--add.svg'" alt="">
            <span>{{ $t('profile.create_profile') }}</span>
          </a>
        </div>
      </div>

      <div class="banner">
        <div class="banner__item">
          <!--<img src="/images/banner.jpg" alt="">-->
        </div>
      </div>
    </div>
    <girl-type-modal ref="select_girl_type"></girl-type-modal>
  </div>
  <!--
  <div class="row" style="position: relative">
    <div class="col-md-12 mb-3">
      <div class="row">
        <div class="col-sm-6">
          <div class="Typography_h2">
            {{ $t('profile.profiles_title') }}
          </div>
        </div>
        <div class="col-sm-6 legend">
          <b-button variant="primary" size="sm" class="float-left float-sm-right" @click="$refs.select_girl_type.open()">
            {{ $t('profile.create_profile') }}
          </b-button>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <b-table
        id="my-table"
        :items="girls"
        :fields="fields"
        stacked="sm"
        small
      >
        <template slot="name" slot-scope="data">
          <img :src="data.item.avatar" v-if="data.item.avatar" style="margin-right: 5px" width="64px">
          {{ data.item.name }}
        </template>
        <template slot="type" slot-scope="data">
          {{ $t('girl_types.'+data.item.type) }}
        </template>
        <template slot="status" slot-scope="data">
          {{ $t('girl_statuses.' + data.item.status) }}
        </template>
        <template slot="actions" slot-scope="data">
          <router-link :to="localePath({ name: 'profile-id', params: { id: data.item.id }})">
            <d-button size="sm">
              {{ $t('girls.edit') }}
            </d-button>
          </router-link>
        </template>
        <template slot="delete" slot-scope="data">
          <d-button size="sm" @click="deleteGirl(data.index, data.item.id)">
            {{ $t('girls.delete') }}
          </d-button>
        </template>
      </b-table>
    </div>
    <div class="col-md-12" v-if="!girls.length">
      {{ $t('profile.not_profiles') }}
    </div>
  </div>-->
</template>

<script>
  import { mapGetters } from 'vuex'
  import ModelBlock from '~/components/ModelBlock'
  import GirlTypeModal from '~/components/GirlTypeModal'
  import {MessageBox} from "element-ui";

  export default {
    layout: 'profile',
    middleware: 'is_girl',

    components: {
      ModelBlock,
      GirlTypeModal
    },

    data() {
      return {
        fields: ['id', 'type', 'name', 'status', 'actions', 'delete'],
      }
    },

    // head() {
    //   return {
    //     title: this.$t('agency_profile.girls_title')
    //   }
    // },

    methods: {
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
          return this.$store.dispatch('girls/deleteGirl', id).then((data) => {
            this.girls.splice(index, 1);
          })
        });
      }
    },

    async asyncData({ store }) {
      return store.dispatch('girls/fetchOwnGirls')
        .then((data) => {
          return {
            girls: data
          }
        })
    },
  }
</script>
