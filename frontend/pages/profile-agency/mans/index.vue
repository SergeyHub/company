<template>
  <div class="row" style="position: relative">
    <div class="col-md-12 mb-3">
      <div class="row">
        <div class="col-md-6">
          <div class="Typography_h2">
            {{ $t('agency_profile.girls_title') }}
          </div>
        </div>
        <div class="col-md-6 legend">
          <b-button variant="primary" size="sm" @click="$refs.select_girl_type.open()">
            {{ $t('agency_profile.add_new_girl') }}
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
          <router-link :to="localePath({ name: 'profile-agency-mans-id', params: { id: data.item.id }})">
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
      {{ $t('agency_profile.not_girls') }}
    </div>
    <girl-type-modal ref="select_girl_type"></girl-type-modal>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import ModelBlock from '~/components/ModelBlock'
  import GirlTypeModal from '~/components/GirlTypeModal'
  import {MessageBox} from "element-ui";

  export default {
    layout: 'profile',
    middleware: 'is_agency',

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

    computed: {
      ...mapGetters('profile', ['agency_profile'])
    },

    async asyncData({ store }) {
      return store.dispatch('profile/fetchAgencyGirls')
        .then((data) => {
          return {
            girls: data
          }
        })
    },
  }
</script>
