<template>
  <div>
    <UsersFilter @update="filterUpdated"/>
    <div>
      <div>

        <div class="container">
          <div>
            <div class="reviews__row">
              <div class="table-responsive">
                <Table
                  :data="users"
                  @sort-change="sortChanged"
                  @row-click="onSelect"
                >
                  <TableColumn
                    prop="id"
                    label="id"
                    width="80"
                    sortable="custom"
                  />
                  <TableColumn
                    prop="email"
                    label="Email"
                    sortable="custom"
                  />
                  <TableColumn
                    prop="status"
                    label="Статус"
                    sortable="custom"
                  />
                  <TableColumn
                    prop="type"
                    label="Тип"
                    sortable="custom"
                  >
                    <template slot-scope="scope">
                      {{ scope.row.type == 'girl' ? 'man' : scope.row.type }}
                    </template>
                  </TableColumn>
                  <TableColumn
                    prop="created_at"
                    label="Зарегистрирован"
                    :formatter="dateFormatter"
                    sortable="custom"
                  />
                  <TableColumn
                    prop="email_verified_at"
                  >
                    <template slot-scope="scope">
                      <span
                        class="text-danger"
                        v-if="!(typeof scope.row.email_verified_at == 'string' && scope.row.email_verified_at.length)"
                      >
                        <a
                          href="#"
                          title="Подтвердить"
                          @click.stop.prevent="confirmEmail(scope.row)"
                        >
                          Email не подтвержден
                        </a>
                      </span>
                      <span
                        class="text-danger"
                        v-if="(typeof scope.row.deleted_at == 'string' && scope.row.deleted_at.length)"
                      >
                        ЗАБАНЕН
                      </span>
                    </template>
                  </TableColumn>
                  <TableColumn
                    label="Профиль"
                  >
                    <template slot-scope="scope">
                      <GirlLink
                        v-if="scope.row.girls.length > 0"
                        :model="scope.row.girls[0]"
                      >
                        <div class="row align-items-center">
                          <img :src="scope.row.girls[0].avatar" alt="" class="avatar-mini">
                          <span class="ml-10">
                            {{ scope.row.girls[0].name }}
                          </span>
                        </div>
                      </GirlLink>
                    </template>
                  </TableColumn>
                </Table>
              </div>
              <p v-if="total == 0">
                {{ $t('errors.models_not_found') }}
              </p>
            </div>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { MessageBox, Message, Table, TableColumn } from 'element-ui'
import UsersFilter from '~/components/UsersFilter'
import GirlLink from '~/components/GirlLink'

export default {
  components: {
    MessageBox,
    Message,
    Table,
    TableColumn,
    UsersFilter,
    GirlLink
  },
  layout: 'admin',

  computed: {
    ...mapGetters('users', ['users']),
  },

  data() {
    return {
      page: 1,
      isBusy: true,
      fields: ['id', 'email', 'type', 'role', 'created_at', 'actions'],
      filter: {},
      sort: 'id',
      sortOrder: 'desc'
    }
  },
  asyncData({store, params}) {
    return store.dispatch('users/listVipUsers', {
      sort: params.sort,
      sortOrder: params.sortOrder
    })
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
    onSelect(user) {
      this.$router.push('/adminkas/users/' + user.id + '/mans')
    },
    filterUpdated(filter) {
      this.filter = filter
      this.loadMore(1)
    },
    async loadMore(page) {
      this.isBusy = true;
      let params = {page: page, ...this.filter, sort: this.sort, sortOrder: this.sortOrder, vip: 1 };
      if(page == 1) {
        await this.$store.dispatch('users/listVipUsers', params)
      } else {
        await this.$store.dispatch('users/loadMoreVipUsers', params)
      }

      this.page = page;
      this.isBusy = false;
    },

    reset() {
      this.query = {
        query: null
      }
    },
    sortChanged(e) {
      //this.users = []
      this.page = 1
      this.sort = e.prop
      this.sortOrder = e.order == 'ascending' ? 'asc' : 'desc'

      this.loadMore(1)
      return false;
    },
    dateFormatter(model) {
      return this.$dayjs(model.created_at).format('YYYY-MM-DD HH:mm')
    }
  }
}
</script>
