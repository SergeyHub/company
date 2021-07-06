<template>
  <div
    class="archive"
    :class="{archive__sidebar: showSidebar}"
  >
    <div class="container">
      <component
        class="archive-title
"
        :is="$props.titleTag"
        v-if="$props.title"
      >
        {{ $props.title }}
      </component>
      <div class="archive__sidebar-wrap">
        <!--<girl-placeholders v-if="loading"/>-->
        <div
          class="archive__row"
          :class="{'archive__row--fourcolumns': fourcolumns}"
        >
          <model-block
            :class="{ 'archive__card--fourcolumns': fourcolumns }"
            v-for="model in girls"
            :key="'girl/'+model.id"
            :model="model"
            :showRemoveButton="$props.showRemoveButton"
            @remove="$emit('remove', $event)"
          />
          <div v-if="total == 0 && !girls.length">
            {{ $t('errors.models_not_found') }}
          </div>
          <!--<div class="loader" v-show="loading && busy">
            <div class="loader__icon">
              <img :src="cdn_assets_prefix + '/files/icons/svg/icon--loader.svg'" alt="">
            </div>
            <span>{{ $t('other.loading') }}</span>
          </div>-->
        </div>
        <sidebar v-if="showSidebar"/>
      </div>
      <div
        class="archive__btn"
        @click="$emit('loadMore')"
        v-if="showLoadMoreButton && !busy"
        :title="$t('load_more')"
      >
        <AppButton>
          {{ $t('load_more') }}
        </AppButton>

      </div>
      <div class="loader" v-if="loading">
        <div class="loader__icon">
          <img src="/files/icons/svg/icon--loader.svg" alt="">
        </div>
        <span>{{ $t('loading_more') }}</span>
      </div>
    </div>
    <columns-selector ref="columnsSelector"/>
  </div>
</template>
<script>
  import GirlPlaceholders from '~/components/GirlPlaceholders'
  import Sidebar from '~/components/Sidebar'
  import ModelBlock from '~/components/ModelBlock'
  import ColumnsSelector from '~/components/GirlsArchive/ColumnsSelector';
  import AppButton from '~/components/AppButton'

  export default {
    props: {
      loading: {
        type: Boolean,
        default: false
      },
      busy: {
        type: Boolean,
        default: false
      },
      last_page: {
        type: Number,
        default: 0
      },
      titleTag: {
        default: 'h2',
        type: String
      },
      total: {
        type: Number,
        default: 0
      },

      girls: {
        type: Array,
        required: true
      },

      showSidebar: {
        type: Boolean,
        default: false
      },
      showLoadMoreButton: {
        type: Boolean,
        default: true
      },
      title: {
        type: String,
        default: null
      },
      showRemoveButton: {
        type: Boolean,
        default: false
      },
      fourcolumns: {
        type: Boolean,
        default: false
      }
    },
    components: {
      Sidebar,
      ModelBlock,
      GirlPlaceholders,
      ColumnsSelector,
      AppButton
    },
    mounted() {
      if($(window).width() <= 1040 && !this.$cookies.get('archiveColumns')) {
        this.$refs.columnsSelector.open()
      }
    }
  }
</script>
