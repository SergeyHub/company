<template>
  <div>
    <div class="Typography_h3">{{ $t('bills.check_payment') }}</div>
    <check-payment-modal :value="true" :billId="bill_id" ref="checkPaymentModal"/>
  </div>
</template>

<script>
  import { EventBus } from "~/utils/event-bus";
  import CheckPaymentModal from '~/components/CheckPaymentModal'

  export default {
    layout: 'profile',

    components: {
      CheckPaymentModal
    },

    data() {
      return {
        bill_id: this.$route.query.bill_id,
      }
    },

    mounted() {
      if(!this.$route.query.bill_id)
        this.$router.push('/profile')

      this.$refs.checkPaymentModal.open();
    }
  }
</script>
