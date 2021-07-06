<template>
  <div class="mt-30 mb-30">
    <div class="container">
      <div
        v-if="bills.length"
        class="reviews__row"
      >
        <div class="table-responsive">
          <Table
            :data="bills"
            @sort-change="sortChanged"
          >
            <TableColumn
              prop="id"
              label="id"
            />
            <TableColumn
              :label="$t('bills.amount')"
            >
              <template slot-scope="scope">
                {{ scope.row.amount }}$
              </template>
            </TableColumn>
            <TableColumn
              prop="status"
              :label="$t('bills.status')"
            >
              <template slot-scope="scope">
                {{ $t('bills.status_' + scope.row.status) }}
                <template v-if="scope.row.payed_at != null">
                  ({{ scope.row.payed_at }})
                </template>
              </template>
            </TableColumn>
            <TableColumn
              prop="created_at"
              :label="$t('bills.created_at')"
            >
              <template slot-scope="scope">
                {{ $dayjs(scope.row.created_at).format('YYYY-MM-DD HH:mm') }}
              </template>
            </TableColumn>
            <TableColumn
              prop="description"
              :label="$t('bills.description')"
            >
              <template slot-scope="scope">
                {{ rowDescription(scope.row) }}
              </template>
            </TableColumn>
          </Table>
          <div class="archive__btn">
            <button
              v-if="!isBusy && last_page != page"
              @click="loadMore(page+1)"
              :title="$t('load_more')"
              class="btn btn-border"
            >
              {{ $t('other.load_more') }}
            </button>
          </div>
        </div>
      </div>
      <div
        v-else
        class="container"
      >
        No bills
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import { Table, TableColumn } from 'element-ui'
  import GirlNav from '~/components/GirlNav'

  export default {
    layout: 'profile',
    middleware: 'is_girl',
    components: {
      GirlNav,
      Table,
      TableColumn
    },

    computed: {
      ...mapGetters('bills', ['bills']),
    },

    data() {
      return {
        page: 1,
        isBusy: true,
        last_page: null
      }
    },
     head() {
       return {
         title: this.$t('profile_nav.orders')
       }
     },
    asyncData({store}) {
      return store.dispatch('bills/fetchBills')
        .then((response) => {
          return {
            last_page: response.meta.last_page,
            total: response.meta.total,
            isBusy: false,
          }
        })
    },
    methods: {
      async loadMore(page) {
        this.isBusy = true;
        let params = {page: page};
        await this.$store.dispatch('bills/fetchBills', params)
          .then((data) => {
            this.last_page = data.last_page
          })
        this.page = page;
        this.isBusy = false;
      },
      rowDescription(row) {
        if(row.type === 'OrderGirlVip') {
          let text = 'VIP';
          if(row.order.cost_type != null) {
            text += '(' + this.$t('bills.durations_' + row.order.cost_type) + ')'
          }

          return text
        }
        return ''
      }
    },
  }
</script>
