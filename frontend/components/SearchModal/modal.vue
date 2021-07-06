<template>
  <modal v-model="showModify" ref="modal">
    <div class="container">
      <div class="search__form">
        <label>{{ $t('other.search_title') }}</label>
        <input v-model="searchInput" type="text" :placeholder="$t('other.search_title')">
      </div>

      <div class="search__result">
        <div class="search__result-text" v-if="busy">
          <div class="loader__icon">
            <img :src="cdn_assets_prefix + '/files/icons/svg/icon--loader.svg'" alt="">{{ $t('other.search_busy') }}
          </div>

        </div>
        <div class="search__result-text" v-if="!busy && total == 0">
          {{ $t('errors.models_not_found') }}
        </div>
        <div class="archive__row">
          <model-block
            v-for="model in girls"
            :key="'girl/'+model.id"
            :model="model"
            @click.native="close() && reset()"
          />
        </div>
        <!--<div class="archive__btn" @click="loadMore" v-if="!busy && total">
          <div class="btn btn-border">
            {{ $t('load_more') }}
          </div>
        </div>-->
      </div>
    </div>
  </modal>
</template>
<script>
import Modal from '~/components/Modal'
import ModelBlock from '~/components/ModelBlock'
import SearchModal from '~/components/SearchModal'

export default {
  components: {
    Modal,
    ModelBlock
  },
  data: function() {
    return {
      showModify: false,
      searchInput: '',

      total: 0,
      girls: [],

      busy: false
    }
  },
  methods: {
    open() {
      this.showModify = true
    },
    close() {
      this.showModify = false
    },
    reset() {
      this.searchInput = ''
    }
  },
  watch: {
    searchInput: {
      handler:
        _.debounce(function(val) {
          if(val == '') return;
          this.busy = true

          this.$store.dispatch('girls/searchGirls', val)
            .then((data) => {
              this.girls = data.data
              this.total = data.meta.total
            })
            .catch((err) => {
              console.log(err)
            })
            .finally(() => {
              this.busy = false
            })
        }, 600),
      deep: true
    }
  },
  beforeMount() {
    SearchModal.EventBus.$on('open', (params) => {
      this.open()
    })
    SearchModal.EventBus.$on('close', (params) => {
      this.close()
    })
  }
}
</script>
<style lang="scss" scoped>
.loader__icon {
  display: flex;
  align-items: center;
  justify-content: center;

  img {
    margin-right: 10px;
  }
}
</style>
