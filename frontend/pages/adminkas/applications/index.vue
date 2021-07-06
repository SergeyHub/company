<template>
  <div>
    <ClientApplicationsFilter @update="updateFilter"/>
    <div class="container">
      <div class="container admin__profiles">
        <div class="archive__reviews reviews">
          <div class="reviews__row">
            <!--
            <client-application-block
              v-for="model in client_applications"
              :key="'client_application/'+model.id"
              :model="model"
              @delete="deleteApplication"
            />
            <p v-if="total == 0">
              {{ $t('errors.models_not_found') }}
            </p>-->
            <Table
              :data="client_applications"
              @sort-change="sortChanged"
            >
              <TableColumn
                label="id"
                prop="id"
                width="60"
                sortable
              />
              <TableColumn
                label="дата отправки"
                prop="created_at"
                sortable
              >
                <template slot-scope="scope">
                  {{ $dayjs(scope.row.created_at).format('YYYY-MM-DD HH:mm') }}
                </template>
              </TableColumn>
              <TableColumn
                label="телефон"
                prop="phone"
                sortable
              />
              <TableColumn
                label="сообщение"
                prop="content"
              >
                <template slot-scope="scope">
                  <a
                    href="#"
                    @click.prevent="showContent(scope.row.content)"
                  >
                    {{ contentPreview(scope.row.content) }}
                  </a>
                </template>
              </TableColumn>
              <TableColumn
                prop="girl.user.type"
                label="Тип"
              >
                <template slot-scope="scope">
                  {{ scope.row.girl != null ? typeTranslate(scope.row.girl.user.type) : '' }}
                </template>
              </TableColumn>
              <TableColumn
                prop="girl.user.email"
                label="Email аккаунта"
              />
              <TableColumn
                label="Гео"
              >
                <template slot-scope="scope">
                  <span v-if="scope.row.girl != null">
                    {{ scope.row.girl.country_name ? scope.row.girl.country_name + ',' : '' }} {{ scope.row.girl.city }}
                  </span>
                </template>
              </TableColumn>
              <TableColumn label="Профиль">
                <template slot-scope="scope">
                  <GirlLink :model="scope.row.girl" v-if="scope.row.girl != null">
                    <div class="row align-items-center" v-if="scope.row.girl !== undefined">
                      <img :src="scope.row.girl.avatar" alt="" class="avatar-mini">
                      <span class="ml-10">
                        {{ scope.row.girl ? scope.row.girl.name : '' }}
                      </span>
                    </div>
                  </GirlLink>
                </template>
              </TableColumn>
            </Table>
          </div>
          <div class="archive__btn">
            <button
              v-if="!busy"
              @click="loadMore(this.page+1)"
              :title="$t('load_more')"
              class="btn btn-border"
            >
              {{ $t('other.load_more') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {mapGetters} from 'vuex'
import { Table, TableColumn, MessageBox } from 'element-ui'
import GirlLink from '~/components/GirlLink'
import ClientApplicationsFilter from '~/components/ClientApplicationsFilter'

export default {
  layout: 'admin',
  components: {
    ClientApplicationsFilter,
    Table,
    TableColumn,
    GirlLink
  },
  computed: {
    ...mapGetters('client_applications', ['client_applications'])
  },
  data() {
    return {
      loading: true,
      busy: true,
      page: 1,

      filter: [],
      sort: null,
      sortOrder: 'desc'
    }
  },
  asyncData({store}) {
    store.commit('client_applications/RESET_APPLICATIONS');
    store.dispatch('girls/setCurrentSection', 'reviews');
    let params = {};

    return store.dispatch('client_applications/fetchApplications', params)
      .then((response) => {
        return {
          loading: false,
          busy: response.meta.last_page == 1,
          last_page: response.meta.last_page,
          total: response.meta.total,
        }
      })

  },
  methods: {
    typeTranslate(type) {
      const types = {
        girl: 'man',
        client: 'client'
      }
      return types[type] !== undefined ? types[type] : type
    },
    sortChanged(e) {
      this.page = 1
      this.sort = e.prop,
      this.sortOrder = e.order == 'ascending' ? 'asc' : 'desc'
      this.loadMore(1)
      return false;
    },
    updateFilter(filter) {
      this.filter = filter

      this.$store.commit('client_applications/RESET_APPLICATIONS')
      this.loadMore(1)
    },
    loadMore(page) {
      this.busy = true;
      if(page == 1) {
        this.$store.commit('client_applications/RESET_APPLICATIONS')
      }
      let params = {page, ...this.filter, sort: this.sort, sortOrder: this.sortOrder};

      this.$store.dispatch('client_applications/fetchApplications', params)
        .then(() => {
          this.busy = false;
        })

      this.page = page
    },
    deleteApplication(model) {
      this.$store.dispatch('client_applications/removeApplication', model.id)
        .then(response => {
          console.log(response)
        })
        .catch(err => {
          console.log(err)
        })
    },
    contentPreview(content) {
      return content.substr(0,35) + (content.length > 35 ? '..' : '')
    },
    showContent(content) {
      MessageBox(content)
    }
  }
}
</script>
