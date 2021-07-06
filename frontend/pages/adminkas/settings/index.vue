<template>
  <div>
    <div class="Typography_h3 mb-4">Настройки</div>

    <b-table
      id="my-table"
      :items="contents"
      :fields="fields"
      per-page="20"
      small
    >
      <template slot="actions" slot-scope="data">
        <router-link :to="localePath({name: 'adminkas-settings-id', params: {id: data.item.id}})">
          <i class="far fa-edit"></i> Edit
        </router-link>
      </template>
    </b-table>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import BButton from "bootstrap-vue/src/components/button/button";

  export default {
    components: { BButton },
    layout: 'admin',

    data() {
      return {
        page: 1,
        fields: ['slug', 'actions'],
      }
    },

    asyncData({ store }) {
      return store.dispatch('content/fetchAllContents')
        .then(({ data }) => {
          return {
            contents: data
          }
        })
    }
  }
</script>
