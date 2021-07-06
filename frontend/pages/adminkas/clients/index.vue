<template>
  <div>
    <div class="Typography_h3 mb-4">Клиенты</div>

    <b-table
      id="my-table"
      :items="clients"
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
      ...mapGetters('clients', ['clients']),
    },

    data() {
      return {
        page: 1,
        isBusy: true,
        fields: ['id', 'name', 'phone', 'user_id', 'created_at', 'actions'],
      }
    },

    asyncData({store}) {
      return store.dispatch('clients/fetchClients')
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
        await this.$store.dispatch('clients/fetchClients', params)
        this.page = page;
        this.isBusy = false;
      }
    }
  }
</script>
