<template>
  <div>
      <div class="fake-write text-center">
        <span class="write-review-button" @click="$refs.write_fake.open()">{{fakeText}}</span>
      </div>
      <fake-modal ref="write_fake"></fake-modal>
  </div>
</template>

<script>
  import Accordion from '~/components/Accordion'
  import FakeModal from '~/components/FakeModal'
  import {mapGetters} from "vuex";

  export default {
    components: {
      Accordion,
      FakeModal
    },
    computed: {
      ...mapGetters('girls', ['current_girl']),
      fakeText(){
        return this.$t('public_profile.write_fake').replace(/%girl%/gi, (this.current_girl.name ))
      }
    },
    data() {
      return {
        slickOptions: {
          slidesToShow: 1,
          arrows: true,
          infinite: true,
          centerMode: false,
        },
      }
    },

  }
</script>
<style lang="scss">
  .fake-write {
    margin-bottom: 15px;
  }
</style>
