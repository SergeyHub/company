<template>
  <modal ref="modal" >
    <div class="girl-type__modal">
      <h1 class="girl-type__modal-title">{{ $t('girl_types.create_title') }}</h1>
      <div class="girl-type__modal-types">
        <AppButton
          mode="custom"
          class="btn btn-border"
          @click.native="createGirl('girls')"
        >{{$t('girl_types.girls')}}</AppButton>
        <!--<AppButton
          mode="custom"
          class="btn btn-border"
          @click.native="createGirl('travels')"
        >{{$t('girl_types.travels')}}</AppButton>
        <AppButton
          mode="custom"
          class="btn btn-border"
          @click.native="createGirl('dating')"
        >{{$t('girl_types.dating')}}</AppButton>-->
      </div>
      <!--
        <b-form-radio value="girls">{{$t('girl_types.girls')}}</b-form-radio>
        <b-form-radio value="travels">{{$t('girl_types.travels')}}</b-form-radio>
        <b-form-radio value="kept-womans">{{$t('girl_types.kept-womans')}}</b-form-radio>
        <b-form-radio value="dating">{{$t('girl_types.dating')}}</b-form-radio>
        <b-form-radio value="shemales">{{$t('girl_types.shemales')}}</b-form-radio>-->
    </div>
    <!--<div class="text-center">
      <button @click.prevent="createGirl" class="brn btn-sm btn-primary">{{$t('girl_types.create')}}</button>
    </div>-->
  </modal>
  <!--<modal v-model="showModify"
         :title="$t('girl_types.create_title')"
         size="md">
    <template slot="footer">
      <b-form-group >
        <b-form-radio-group
          id="btn-radios-1"
          v-model="girl_type"
          name="radios-btn-default"
          class="w-100"
        >
          <b-form-radio value="girls">{{$t('girl_types.girls')}}</b-form-radio>
          <b-form-radio value="travels">{{$t('girl_types.travels')}}</b-form-radio>
          <b-form-radio value="dating">{{$t('girl_types.dating')}}</b-form-radio>
        </b-form-radio-group>
      </b-form-group>
      <div class="text-center">
        <button @click.prevent="createGirl" class="brn btn-sm btn-primary">{{$t('girl_types.create')}}</button>
      </div>
    </template>

  </modal>-->
</template>

<script>
  import Modal from '~/components/Modal'
  import AppButton from '~/components/AppButton'
  import {mapGetters} from "vuex";

  export default {
    props: {
      value: {
        type: Boolean,
        default: () => false
      }
    },
    components: {
      Modal,
      AppButton
    },
    computed: {
      ...mapGetters('auth', ['isAgency']),
    },
    data() {
      return {
        showModify: this.value,
      }
    },
    methods: {
      open() {
        this.$refs.modal.open()
      },
      close() {
        this.$refs.modal.close()
      },
      createGirl(type) {
        let data = {'type': type}
        if (this.isAgency) {
          this.$store.dispatch('profile/createGirl', data)
            .then((data) => {
              this.$refs.modal.close()
              this.$router.push(this.localePath({
                name: 'profile-agency-mans-id',
                params: {id: data.id}
              }))
            })
        } else {
          this.$store.dispatch('profile/createGirlByGirl', data)
            .then((data) => {
              this.$refs.modal.close()
              this.$router.push(this.localePath({
                name: 'profile-id',
                params: {id: data.id}
              }))
            })
        }
      }
    },
    beforeMount() {
    }
  }
</script>

<style lang="scss" scoped>
h1 {
  color: white;
}

.girl-type__modal {
  min-height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  &-types {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;

    .btn {
      margin-bottom: 8px;
    }
  }

  &-title {
    margin-bottom: 20px;
  }
}
</style>

