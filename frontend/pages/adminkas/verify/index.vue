<template>
  <div>
    <VerifyGirlsFilter @update="filterUpdated"/>
    <Table
      :data="girls"
      @sort-change="sortChanged"
      @row-click="onSelect"
    >
      <TableColumn
        prop="id"
        label="id"
        sortable="custom"
      />
      <TableColumn
        prop="user.id"
        label="User id"
        sortable="custom"
      />
      <TableColumn
        label="Дата отправки"
      >
        <template slot-scope="scope" v-if="typeof scope.row.documents == 'object' && scope.row.documents.length">
          {{ $dayjs(scope.row.documents[0].created_at).format('YYYY-MM-DD HH:mm') }}
        </template>
      </TableColumn>
      <TableColumn
        label="Документы"
        prop="documents"
      >
        <template slot-scope="scope">
          <div>
            <a
              v-for="document in scope.row.documents"
              :key="document.id"
              :href="document.url"
              data-fancybox="gallery"
            >
              <img
                :src="document.url"
                class="avatar-mini"
              >
            </a>
          </div>
        </template>
      </TableColumn>
      <TableColumn
        label="Профиль"
        prop="link"
      >
        <template slot-scope="scope">
          <GirlLink :model="scope.row">
            <div class="row align-items-center">
              <img :src="scope.row.avatar" alt="" class="avatar-mini">
              <span class="ml-10">
                {{ scope.row.name }}
              </span>
            </div>
          </GirlLink>
        </template>
      </TableColumn>
      <TableColumn
        label="Верификация"
        prop="verified"
        sortable="custom"
      >
        <template slot-scope="scope">
          <a
            v-if="scope.row.verified == 'rejected'"
            @click.stop.prevent="showRejectedReason(scope.row)"
            href="#"
          >
            {{ scope.row.verified }}
          </a>
          <template v-else>
            {{ scope.row.verified }}
          </template>
        </template>
      </TableColumn>

      <TableColumn
        prop="verified_at"
        label="Дата верификации"
        sortable="custom"
      >
        <template slot-scope="scope" v-if="scope.row.verified_at != null">
          {{ $dayjs(scope.row.verified_at).format('YYYY-MM-DD HH:mm') }}
        </template>
      </TableColumn>

      <TableColumn
        prop="buttons"
      >
        <template slot-scope="scope">
          <button
            v-if="scope.row.verified == 'wait' || scope.row.verified == 'rejected' || scope.row.verified == 'no'"
            @click="setVerified(scope.row)"
            class="btn btn-mess"
          >Верифицировать</button>
          <button
            v-if="scope.row.verified == 'wait' || scope.row.verified == 'yes'"
            @click="setUnverified(scope.row)"
            class="btn btn-border"
          >Отклонить</button>
        </template>
      </TableColumn>
    </Table>
    <div class="archive__btn">
      <button
        v-if="!isBusy"
        @click="loadMore(page+1)"
        :title="$t('load_more')"
        class="btn btn-border"
      >
        {{ $t('other.load_more') }}
      </button>
    </div>
    <VerifyRejectionModal
      ref="verifyRejectionModal"
    />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { MessageBox, Message } from 'element-ui'
import ReviewBlock from '~/components/ReviewBlock'
import { Table, TableColumn } from 'element-ui'
import GirlLink from '~/components/GirlLink'
import VerifyGirlsFilter from '~/components/VerifyGirlsFilter'
import VerifyRejectionModal from '~/components/VerifyRejectionModal'

export default {
  components: {
    ReviewBlock,
    Table,
    TableColumn,
    GirlLink,
    VerifyGirlsFilter,
    VerifyRejectionModal
  },
  layout: 'admin',

  computed: {
    ...mapGetters('girls', ['girls']),
  },

  data() {
    return {
      page: 1,
      isBusy: true,
      filter: null,
      sort: null,
      sortOrder: null,
      fields: ['id', 'model_id', 'email', 'created_at', 'actions']
    }
  },
  asyncData({ store }) {
    return store.dispatch('girls/fetchVerificationGirls')
      .then((response) => {
        return {
          last_page: response.meta.last_page,
          total: response.meta.total,
          isBusy: false,
        }
      })
  },

  watch: {
    query: {
      deep: true,
      handler(newVal, oldVal) {
        this.loadMore(1)
      }
    }
  },

  methods: {
    onSelect(profile, column) {
      if(['documents', 'link', 'buttons'].findIndex((item) => item === column.property) === -1) {
        if(profile != null) {
          this.$router.push('/adminkas/users/' + profile.user.id + '/mans')
        }
      }
    },
    sortChanged(e) {
      this.page = 1
      this.sort = e.prop,
      this.sortOrder = e.order == 'ascending' ? 'asc' : 'desc'

      if(this.sort == 'user.id') this.sort = 'user_id'

      this.loadMore(1)
      return false;
    },
    rejectedReasonPreview(girl) {
      let reason = girl.rejected_verification_reason
      if(reason.ru && reason.ru.length) {
        reason = reason.ru
      } else if(reason.en && reason.en.length) {
        reason = reason.en
      } else {
        reason = '';
      }

      return reason.substr(0,35) + (reason.length > 35 ? '..' : '')
    },
    showRejectedReason(girl) {
      let reason = girl.rejected_verification_reason
      if(typeof JSON.parse(girl.rejected_verification_reason) == 'object') {
        reason = Object.values(JSON.parse(girl.rejected_verification_reason)).join('<br><br>--------<br><br>')
      }
      MessageBox({message: reason, dangerouslyUseHTMLString: true})
    },
    setVerified(model) {
      this.$store.commit('girls/SET_GIRL', model)
      this.$store.dispatch('girls/verifyGirl', { ...model })
    },
    setUnverified(model) {
      this.$refs.verifyRejectionModal.open(model);
      /*
      MessageBox.prompt('Enter reason please', 'Reject application', {
        confirmButtonText: 'Continue',
        cancelButtonText: 'Back',
        inputType: 'textarea'
      })
      .then(({ value }) => {
        let reason = value;
        this.$store.commit('girls/SET_GIRL', model)
        this.$store.dispatch('girls/unverifyGirl', { ...model, reason })
      })*/
    },
    filterUpdated(filter) {
      this.filter = filter
      this.loadMore(1)
    },

    async loadMore(page) {
      this.isBusy = true;
      let params = {page: page, ...this.filter, sort: this.sort, sortOrder: this.sortOrder};
      if(page == 1) {
        this.$store.commit('girls/RESET_GIRLS')
      }
      await this.$store.dispatch('girls/fetchVerificationGirls', params)
      this.page = page;

      this.isBusy = false;
    },
    reset() {
      this.query = {
        query: null
      }
    },

    appendScripts() {
      var element = document.getElementById('fancybox_script');
      element && element.remove();
      var script = document.createElement('script');
      script.src = process.env.cdn_assets + '/fancybox/jquery.fancybox.js';
      script.id = 'fancybox_script';
      document.head.append(script);
    },
  },
  mounted() {
    this.appendScripts()
    this.$store.dispatch('girls/fetchVerificationGirls')
  }
}
</script>
