<template>
  <div>
    <modal v-model="showModify" :title="title" v-loading="loading">
        <template slot="header">
          <span>{{ $t('payments.select_payment_method') }}</span>
        </template>
        <div class="payment_methods">
          <div class="payment_method" :class="method === 'card' ? 'active' : ''" @click="method='card'">
            <img :src="cdn_assets + '/img/cards.png'">
          </div>
        </div>
        <d-button class="w-100" @click="pay">{{ $t('payments.pay') }} {{bill.amount}} $</d-button>

        <template slot="footer">
          <ul class="acquiring_description">
            <li>
              Accepted Cards: Visa, Mastercard, American Express, JCB, Discover
            </li>
            <li>
              Your card details will be stored only by Yandex
            </li>
            <li>
              Your purchase will be billed as "Yandex Money"
            </li>
            <li>
              All fraudulent transactions will be investigated.
            </li>
          </ul>
        </template>
    </modal>
  </div>
</template>

<script>
  import Modal from '~/components/Modal'
  import PaymentModal from '~/components/PaymentModal'

  export default {
    components: { Modal },
    data() {
      return {
        bill: {},
        title: '',
        showModify: this.value,
        method: 'card',
        loading: false,
        wallet: '41001844143583',
        cdn_assets: process.env.cdn_assets,
      }
    },
    watch: {
      showModify(newVal, prevVal) {
        this.$emit('input', newVal)
      }
    },
    methods: {
      open(params={}) {
        if(params.bill)
          this.bill = params.bill;
        if(params.title)
          this.title = params.title;
        this.showModify = true;
      },
      close() {
        this.showModify = false
      },
      getActiveWallet() {
        if(this.wallet)
          return this.wallet;
      },
      pay() {
        var locale = this.$i18n.locale !== 'en' ? '/' + this.$i18n.locale  : '';
        var success_url = 'https://'+window.location.hostname+locale+'/profile/checkpayment?bill_id='+this.bill.id;
        var params = {
          'receiver': this.getActiveWallet(),
//          'sum': this.bill.amount * 65,
          'sum': 10,
          'successURL': success_url,
          'quickpay-back-url': success_url,
          'shop-host': window.location.hostname,
          'label': this.bill.id,
          'targets': this.title,
          'comment': '',
          'origin': 'form',
          'selectedPaymentType': this.method === 'card' ? 'AC' : 'PC',
          'destination': this.title,
          'form-comment': this.title,
          'short-dest': '',
          'quickpay-form': 'shop',
          'lang': this.$i18n.locale,
        };
        var final_url = 'https://money.yandex.ru/transfer?' + jQuery.param(params)
        window.open(final_url)
      }
    },
    beforeMount() {
      PaymentModal.EventBus.$on('open', (params) => {
        this.open(params)
      })
    }
  }
</script>

<style>
  .payment_methods {
    width: 100%;
    margin: 20px 0;
  }
  .payment_methods .payment_method {
    width: 100%;
    height: 70px;
    margin: 10px auto;
    border-radius: 8px;
    background-image: linear-gradient(180deg, #fff, #d8d8d8);
    border: 1px solid #979797;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    text-align: center;
    cursor: pointer;
  }
  .payment_methods .payment_method.active {
    background-image: linear-gradient(180deg, #fff, #73afff);
  }
  .payment_methods .payment_method img {
    height: 45px;
  }
  ul.acquiring_description {
    font-size: 11px;
    color: #bdbdbd;
    text-align: left;
    margin-left: 13px;
    margin-top: 10px;
    padding: 0;
  }
</style>
