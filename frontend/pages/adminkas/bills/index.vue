<template>
  <div>
    <div class="Typography_h3 mb-4">Счета</div>

    <b-table
      id="my-table"
      :items="bills"
      per-page="0"
      :fields="fields"
      :busy="isBusy"
      :current-page="page"
      small
    >
      <template slot="created_at" slot-scope="data">
        {{ data.item.created_at ? (new Date(data.item.created_at)).toLocaleString() : '' }}
      </template>
      <template slot="actions" slot-scope="data">
        <i class="far fa-edit"></i> Edit
        |
        <i class="fa fa-times"></i> Delete
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
</template>

<script>
  import { mapGetters } from 'vuex'
  import BButton from "bootstrap-vue/src/components/button/button";

  export default {
    components: {BButton},
    layout: 'admin',

    computed: {
      ...mapGetters('bills', ['bills']),
    },

    data() {
      return {
        page: 1,
        isBusy: true,
        fields: ['id', 'amount', 'type', 'status', 'payed_at', 'created_at', 'actions'],
      }
    },

    asyncData({store}) {
      return store.dispatch('bills/fetchAllBills')
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
        await this.$store.dispatch('bills/fetchAllBills', params)
        this.page = page;
        this.isBusy = false;
      }
    }
  }
</script>
