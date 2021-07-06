<template>
  <div>
    <modal v-model="showModify" :title="$t('other.select_tariff')" size="lg" hide-header hide-footer	centered>
      <div class="row" v-loading="loading">
        <div class="col-md-4" v-for="(tariff, index) in tariffs" :key="index">
          <div class="tariff_block" :class="{active_tariff: tariff.id == selected_tariff}">
            <div class="tariff_name">
              {{ tariff.name }}
            </div>
            <div class="tariff_cost">
              {{ tariff.cost }} $
            </div>
            <hr>
            <template v-if="tariff.description">
              <div class="tariff_description">
                {{ tariff.description }}
              </div>
              <hr>
            </template>
            <b-button variant="primary" @click="selectTariff(tariff.id)">
              {{ $t('other.pay') }}
            </b-button>
          </div>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import BAlert from "bootstrap-vue/src/components/alert/alert";
  import Modal from "../Modal";
  import { Message } from 'element-ui'

  export default {
    components: {Modal, BAlert},
    data() {
      return {
        showModify: this.value,
        selected_tariff: 2,
        loading: false,
      }
    },
    watch: {
      showModify(newVal, prevVal) {
        this.$emit('input', newVal)
      },
      value(newVal, prevVal) {
        this.showModify = newVal
      }
    },
    computed: {
      ...mapGetters('girls', ['tariffs']),
      ...mapGetters('profile', ['independent_profile'])
    },
    methods: {
      async open() {
        this.showModify = true;
        if(!this.tariffs.length)
          await this.$store.dispatch('girls/fetchTariffs')
      },
      close() {
        this.showModify = false
      },
      selectTariff(tariff_id) {
        this.loading = true;
        let data = {
          id: this.independent_profile.id,
          tariff: tariff_id
        };
        this.$store.dispatch('girls/fetchPublicationBill',data)
          .then((data) => {
            this.loading = false;
            this.close();
            this.$paymentModal.open({
              title: this.$t('payments.girl_publication_title'),
              bill: data,
            })
          })
          .catch(() => {
            this.loading = false;
            Message.error('Error')
          })
      }
    }
  }
</script>

<style lang="scss">
  .tariff_block {
    background: #ffffff;
    border: 2px solid #fae9d8;
    border-radius: 10px;
    padding: 15px;
    position: relative;
    text-align: center;
    &.active_tariff {
      box-shadow: inset 0 -1px 0 0 rgba(0,0,0,.1), 0 16px 16px 0 rgba(19,41,104,.2);
    }
    .tariff_name {
        text-align: center;
        color: #fe5f55;
        text-transform: uppercase;
        font-size: 14px;
        margin-bottom: 0;
    }
    .tariff_cost {
      font-size: 24px;
      font-weight: bold;
    }
  }
</style>
