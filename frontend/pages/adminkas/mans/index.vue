<template>
  <div>
    <AdminGirlsFilter @update="filterUpdated"/>
    <div>
      <div class="reviews__row">
        <div class="table-responsive">
          <Table
            :data="girls"
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
              prop="user_id"
              label="Пользователь"
              sortable="custom"
            >
              <template slot-scope="scope">
                <a href="#" @click.prevent.stop="goToUser(scope.row.user)">
                  {{ scope.row.user.id }}
                </a>
              </template>
            </TableColumn>
            <TableColumn
              prop="created_at"
              label="Зарегистрирован"
              sortable="custom"
            >
              <template slot-scope="scope">
                {{ $dayjs(scope.row.created_at).format('YYYY-MM-DD HH:mm') }}
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
              label="Страна"
              prop="country_id"
              sortable="custom"
            >
              <template slot-scope="scope">
                {{ scope.row.country_name }}
              </template>
            </TableColumn>
            <TableColumn
              label="Город"
              prop="city_id"
              sortable="custom"
            >
              <template slot-scope="scope">
                {{ scope.row.city_name }}
              </template>
            </TableColumn>
            <TableColumn
              prop="status"
              label="Статус"
              sortable="custom"
            />
            <TableColumn
              prop="reviews_count"
              label="Отзывы"
              sortable="custom"
            />

            <TableColumn
              prop="client_applications_count"
              label="Заявок"
              sortable="custom"
            />
            <TableColumn
              prop="vip"
              label="Vip"
            >
              <template slot-scope="scope">
                <span
                  v-if="scope.row.vip == 1"
                  class="text-accent cursor__no-drop"
                  @click="removeVip(scope.row)"
                >
                  VIP
                  <span v-show="scope.row.vip_end_date != null">
                    (до {{ $dayjs(scope.row.vip_end_date).format('YYYY-MM-DD HH:mm') }})
                  </span>
                  <span>
                    ({{ scope.row.vip_orders_amount }}$)
                  </span>
                </span>
                <AppButton
                  @click.native.prevent="makeVip(scope.row)"
                  v-else
                >Make vip</AppButton>
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
    <div ref="datepicker">
      <date-picker/>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import AdminGirlsFilter from '~/components/AdminGirlsFilter'
import { Table, TableColumn, MessageBox } from 'element-ui'
import GirlLink from '~/components/GirlLink'
import AppButton from '~/components/AppButton'

export default {
  components: { AdminGirlsFilter, Table, TableColumn, GirlLink, AppButton },
  layout: 'admin',

  computed: {
    ...mapGetters('girls', ['girls']),
  },

  filters: {
    statusName(status) {
      if(status === 'wait')
        return 'Не заполнил';
      if(status === 'active')
        return 'Ждет проверку';
      if(status === 'published')
        return 'Опубликован';
      return 'Не опубликован'
    },
    verifiedStatusName(status) {
      if(status === 'no')
        return 'Не проверена';
      if(status === 'yes')
        return 'Проверена';
      if(status === 'wait')
        return 'Ждет проверку';
      return 'Отказ'
    }
  },

  data() {
    return {
      isBusy: true,
      fields: ['id', 'avatar', 'name', 'city', 'user_id', 'status', 'verified', 'actions'],
      filter: null,
      sort: 'created_at',
      sortOrder: null,
      page: 1,
      statuses: [
        {val: 'wait', name: 'Не заполнил'},
        {val: 'active', name: 'Ждет проверку'},
        {val: 'published', name: 'Опубликован'},
        {val: 'rejected', name: 'Не опубликованы'},
      ],
      verify_statuses: [
        {val: 'no', name: 'Не прошел проверку документов'},
        {val: 'wait', name: 'Ожидает проверку документов'},
        {val: 'yes', name: 'Документы проверены'},
        {val: 'rejected', name: 'Проверка отказана'},
      ]
    }
  },

  asyncData({store}) {
    return store.dispatch('girls/fetchAllGirls')
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
    goToUser(user) {
      this.$router.push('/adminkas/users/' + user.id + '/mans')
    },
    onSelect(row, column) {
      if(['link', 'vip', 'user_id'].indexOf(column.property) !== -1) return;

      this.$router.push(this.localePath({ name: 'adminkas-mans-id', params: { id: row.id }}))
    },
    sortChanged(e) {
      this.sort = e.prop
      this.sortOrder = e.order == 'ascending' ? 'asc' : 'desc'

      this.loadMore(1)
      return false;
    },
    makeVip(girl) {
      MessageBox.prompt('На сколько дней выдать вип?', 'Выдать вип', {
        title: 'Message',
        inputType: 'number',
        inputValue: 365
      })
      .then(({ value }) => {
        this.$store.dispatch('girls/makeVip', { id: girl.id, days: value })
      })
    },
    removeVip(girl) {
      MessageBox.confirm('Обнулить Vip статус?', 'Обнулить вип')
        .then(res => {
          this.$store.dispatch('girls/removeVip', { id: girl.id })
        })
    },
    filterUpdated(filter) {
      this.filter = filter
      this.loadMore(1)
    },
    async loadMore(page) {
      this.isBusy = true;
      this.page = page;
      if(page == 1) {
        this.$store.commit('girls/RESET_GIRLS')
      }
      let response = await this.$store.dispatch('girls/fetchAllGirls', {
        page,
        ...this.filter,
        sort: this.sort,
        sortOrder: this.sortOrder
      });
      this.last_page = response.meta.last_page;
      this.total = response.meta.total;
      this.isBusy = false;
    },

    reset() {
      this.query = {
        query: '',
        status: [],
        verified: [],
      }
    }
  }
}
</script>
