<template>
  <div>
    <modal v-model="showModify" :title="$t('bills.check_payment')">
      <template slot="header">
        {{ $t('bills.' + status) }}
      </template>
      <div class="payment-check-placeholder" v-loading="loading">
        <div class="icon icon--order-success svg" v-if="status == 'paid'">
          <svg xmlns="http://www.w3.org/2000/svg">
            <g fill="none" stroke="#8EC343" stroke-width="2">
              <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
              <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
            </g>
          </svg>
        </div>
        <template v-if="status !== 'active' && status !== 'paid'">
          <div class="f-modal-icon f-modal-error animate">
            <span class="f-modal-x-mark">
              <span class="f-modal-line f-modal-left animateXLeft"></span>
              <span class="f-modal-line f-modal-right animateXRight"></span>
            </span>
            <div class="f-modal-placeholder"></div>
            <div class="f-modal-fix"></div>
          </div>
        </template>
      </div>
      <template slot="footer" v-if="status !== 'active' && status !== 'paid'">
        <span>{{ $t('bills.have_a_problem') }}</span>
        <a href="#" @click.prevent="mode='login'">
          <span>{{ $t('bills.contact_with_support') }}</span>
        </a>
      </template>
      <template slot="footer" v-if="status === 'paid'">
        <b-button variant="primary" @click="continueWork">
          {{ $t('bills.continue') }}
        </b-button>
      </template>
    </modal>
  </div>
</template>

<script>
  import Modal from '~/components/Modal'
  import { EventBus } from "~/utils/event-bus";

  export default {
    components: { Modal },
    props: {
      billId: {
        type: String,
        default: () => ''
      },
      title: {
        type: String,
        default: () => ''
      },
      value: {
        type: Boolean,
        default: () => false
      }
    },
    data() {
      return {
        showModify: this.value,
        loading: true,
        status: 'active',
        interval_loop: null,
        count_checks: 0,
        bill: null
      }
    },
    watch: {
      showModify(newVal, prevVal) {
        this.$emit('input', newVal)
        if(!newVal)
          this.clearInterval()
      }
    },
    methods: {
      open() {
        this.showModify = true;
        this.mainLoop();
      },
      close() {
        this.showModify = false;
      },
      setStatus(status='paid') {
        this.status = status;
        this.loading = false;
      },
      clearInterval() {
        clearInterval(this.interval_loop)
      },
      checkPaymentLoop() {
        // если счет оплачен
        if(this.status !== 'active') {
          this.clearInterval();
          return;
        }

        if(this.count_checks > 20) {
          this.setStatus('not_found_pay');
          return;
        }

        // проверяем статус оплаты счета
        this.$store.dispatch('bills/getBill', this.billId)
          .then(({ data }) => {
            if(data.status === 'active') {
              this.count_checks++;
            } else {
              this.setStatus(data.status);
              this.bill = data;
              this.eventsProcessing();
            }
          })
          .catch((error) => {
            if(error.response.status === 403) {
              this.setStatus('not_found_bill');
              this.clearInterval();
            }
          })
      },
      mainLoop() {
        EventBus.$on("BillPaid", ({ bill_id, bill_type }) => {
          if(bill_id == this.billId) {
            this.setStatus('paid');
            this.bill = {id: bill_id, type: bill_type};
            this.eventsProcessing();
          }
        });
        this.interval_loop = setInterval(this.checkPaymentLoop.bind(this), 3000);
      },

      eventsProcessing(bill_type) {
        if(bill_type == 'OrderGirlPublication') {
          this.$ga.event('girl', 'publication_paid');
        }
        if(bill_type == 'OrderBuyOfferPhone') {
          this.$ga.event('girl', 'buy_offer_phone');
        }
        if(bill_type == 'OrderGirlPhone') {
          this.$ga.event('client', 'buy_girl_phone');
        }
        if(bill_type == 'OrderOfferPublication') {
          this.$ga.event('client', 'pay_offer');
        }
      },

      continueWork() {
        this.close();
        // продолжение дальнейшей работы с сайтом
        // если оплата за публикацию анкеты, то переходим на страницу проверки профиля
        if(this.bill && this.bill.type == 'OrderGirlPublication') {
          this.$router.push('/profile/validate');
        }
      }
    }
  }
</script>

<style lang="scss">
  .payment-check-placeholder {
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  @-webkit-keyframes checkmark {
    0% {
      stroke-dashoffset: 50px
    }

    100% {
      stroke-dashoffset: 0
    }
  }

  @-ms-keyframes checkmark {
    0% {
      stroke-dashoffset: 50px
    }

    100% {
      stroke-dashoffset: 0
    }
  }

  @keyframes checkmark {
    0% {
      stroke-dashoffset: 50px
    }

    100% {
      stroke-dashoffset: 0
    }
  }

  @-webkit-keyframes checkmark-circle {
    0% {
      stroke-dashoffset: 240px
    }

    100% {
      stroke-dashoffset: 480px
    }
  }

  @-ms-keyframes checkmark-circle {
    0% {
      stroke-dashoffset: 240px
    }

    100% {
      stroke-dashoffset: 480px
    }
  }

  @keyframes checkmark-circle {
    0% {
      stroke-dashoffset: 240px
    }

    100% {
      stroke-dashoffset: 480px
    }
  }

  .icon--order-success svg {
    height: 72px;
    width: 72px;
  }

  .icon--order-success svg path {
    -webkit-animation: checkmark 0.25s ease-in-out 0.7s backwards;
    animation: checkmark 0.25s ease-in-out 0.7s backwards
  }

  .icon--order-success svg circle {
    -webkit-animation: checkmark-circle 0.6s ease-in-out backwards;
    animation: checkmark-circle 0.6s ease-in-out backwards
  }

  .f-modal-icon {
    border-radius: 50%;
    border: 4px solid gray;
    box-sizing: content-box;
    height: 80px;
    margin: 20px auto;
    padding: 0;
    position: relative;
    width: 80px;

    // Success icon
    &.f-modal-success,
    &.f-modal-error {
      border-color: #A5DC86;

      &:after,
      &:before {
        background: #fff;
        content: '';
        height: 120px;
        position: absolute;
        transform: rotate(45deg);
        width: 60px;
      }

      &:before {
        border-radius: 120px 0 0 120px;
        left: -33px;
        top: -7px;
        transform-origin: 60px 60px;
        transform: rotate(-45deg);
      }

      &:after {
        border-radius: 0 120px 120px 0;
        left: 30px;
        top: -11px;
        transform-origin: 0 60px;
        transform: rotate(-45deg);
      }

      .f-modal-placeholder {
        border-radius: 50%;
        border: 4px solid rgba(165, 220, 134, .2);
        box-sizing: content-box;
        height: 80px;
        left: -4px;
        position: absolute;
        top: -4px;
        width: 80px;
        z-index: 2;
      }

      .f-modal-fix {
        background-color: #fff;
        height: 90px;
        left: 28px;
        position: absolute;
        top: 8px;
        transform: rotate(-45deg);
        width: 5px;
        z-index: 1;
      }

      .f-modal-line {
        background-color: #A5DC86;
        border-radius: 2px;
        display: block;
        height: 5px;
        position: absolute;
        z-index: 2;

        &.f-modal-tip {
          left: 14px;
          top: 46px;
          transform: rotate(45deg);
          width: 25px;
        }

        &.f-modal-long {
          right: 8px;
          top: 38px;
          transform: rotate(-45deg);
          width: 47px;
        }
      }
    }

    // Error icon
    &.f-modal-error {
      border-color: #F27474;

      .f-modal-x-mark {
        display: block;
        position: relative;
        z-index: 2;
      }

      .f-modal-placeholder {
        border: 4px solid rgba(200, 0, 0, .2);
      }

      .f-modal-line {
        background-color: #F27474;
        top: 37px;
        width: 47px;

        &.f-modal-left {
          left: 17px;
          transform: rotate(45deg);
        }

        &.f-modal-right {
          right: 16px;
          transform: rotate(-45deg);
        }
      }
    }

    // Warning icon

    &.f-modal-warning {
      border-color: #F8BB86;

      &:before {
        animation: pulseWarning 2s linear infinite;
        background-color: #fff;
        border-radius: 50%;
        content: "";
        display: inline-block;
        height: 100%;
        opacity: 0;
        position: absolute;
        width: 100%;
      }

      &:after {
        background-color: #fff;
        border-radius: 50%;
        content: '';
        display: block;
        height: 100%;
        position: absolute;
        width: 100%;
        z-index: 1;
      }
    }

    &.f-modal-warning .f-modal-body {
      background-color: #F8BB86;
      border-radius: 2px;
      height: 47px;
      left: 50%;
      margin-left: -2px;
      position: absolute;
      top: 10px;
      width: 5px;
      z-index: 2;
    }

    &.f-modal-warning .f-modal-dot {
      background-color: #F8BB86;
      border-radius: 50%;
      bottom: 10px;
      height: 7px;
      left: 50%;
      margin-left: -3px;
      position: absolute;
      width: 7px;
      z-index: 2;
    }

    + .f-modal-icon {
      margin-top: 50px;
    }
  }

  .animateSuccessTip {
    animation: animateSuccessTip .75s;
  }

  .animateSuccessLong {
    animation: animateSuccessLong .75s;
  }

  .f-modal-icon.f-modal-success.animate:after {
    animation: rotatePlaceholder 4.25s ease-in;
  }

  .f-modal-icon.f-modal-error.animate:after {
    animation: rotatePlaceholder 4.25s ease-in;
  }

  .animateErrorIcon {
    animation: animateErrorIcon .5s;
  }

  .animateXLeft {
    animation: animateXLeft .75s;
  }

  .animateXRight {
    animation: animateXRight .75s;
  }

  .scaleWarning {
    animation: scaleWarning 0.75s infinite alternate;
  }

  .pulseWarningIns {
    animation: pulseWarningIns 0.75s infinite alternate;
  }

  @keyframes animateSuccessTip {
    0%,54% {
      width: 0;
      left: 1px;
      top: 19px;
    }

    70% {
      width: 50px;
      left: -8px;
      top: 37px;
    }

    84% {
      width: 17px;
      left: 21px;
      top: 48px;
    }

    100% {
      width: 25px;
      left: 14px;
      top: 45px;
    }
  }

  @keyframes animateSuccessLong {
    0%,65% {
      width: 0;
      right: 46px;
      top: 54px;
    }

    84% {
      width: 55px;
      right: 0;
      top: 35px;
    }

    100% {
      width: 47px;
      right: 8px;
      top: 38px;
    }
  }

  @keyframes rotatePlaceholder {
    0%,5% {
      transform: rotate(-45deg);
    }

    100%,12% {
      transform: rotate(-405deg);
    }
  }

  @keyframes animateErrorIcon {
    0% {
      transform: rotateX(100deg);
      opacity: 0;
    }

    100% {
      transform: rotateX(0deg);
      opacity: 1;
    }
  }

  @keyframes animateXLeft {
    0%,
    65% {
      left: 82px;
      top: 95px;
      width: 0;
    }

    84% {
      left: 14px;
      top: 33px;
      width: 47px;
    }

    100% {
      left: 17px;
      top: 37px;
      width: 47px;
    }
  }

  @keyframes animateXRight {
    0%,
    65% {
      right: 82px;
      top: 95px;
      width: 0;
    }

    84% {
      right: 14px;
      top: 33px;
      width: 47px;
    }

    100% {
      right: 16px;
      top: 37px;
      width: 47px;
    }
  }

  @keyframes scaleWarning {
    0% {
      transform: scale(1);
    }

    30% {
      transform: scale(1.02);
    }

    100% {
      transform: scale(1);
    }
  }

  @keyframes pulseWarning {
    0% {
      background-color: #fff;
      transform: scale(1);
      opacity: 0.5;
    }

    30% {
      background-color: #fff;
      transform: scale(1);
      opacity: 0.5;
    }

    100% {
      background-color: #F8BB86;
      transform: scale(2);
      opacity: 0;
    }
  }

  @keyframes pulseWarningIns {
    0% {
      background-color: #F8D486;
    }

    100% {
      background-color: #F8BB86;
    }
  }

</style>
