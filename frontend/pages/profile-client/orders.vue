<template>
  <!--<div class="row" style="position: relative">
    <div class="col-md-12 mb-3">
      <div class="Typography_h2">{{ $t('orders.title') }}</div>
    </div>
    <div class="col-md-12">
      <b-table
        id="my-table"
        :items="bills"
        per-page="0"
        :fields="fields"
        :busy="isBusy"
        :current-page="page"
        small
      >
        <template slot="amount" slot-scope="data">
          {{ data.item.amount }} $
        </template>
        <template slot="created_at" slot-scope="data">
          {{ data.item.created_at ? (new Date(data.item.created_at)).toLocaleString() : '' }}
        </template>
      </b-table>

      <b-pagination
        :value="page"
        @input="loadMore"
        :total-rows="total"
        :per-page="20"
        aria-controls="my-table"
      ></b-pagination>
    </div>
  </div>-->
  <div>
    <girl-nav/>
    <div class="container p-30">
      No bills
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    layout: 'profile',
    middleware: 'is_client',

    computed: {
      ...mapGetters('bills', ['bills']),
    },

    data() {
      return {
        page: 1,
        isBusy: true,
        fields: ['id', 'amount', 'status', 'payed_at', 'created_at'],
      }
    },

    // head() {
    //   return {
    //     title: this.$t('profile_nav.orders')
    //   }
    // },


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
        this.page = page;
        this.isBusy = false;
      }
    }

  }
</script>
