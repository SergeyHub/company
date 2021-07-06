<template>
  <div>
    <div class="Typography_h3">
      {{ data.slug }}
    </div>
    <textarea-multilang v-model="data.content" />
    <b-button variant="primary" @click="save">Сохранить</b-button>
  </div>
</template>

<script>
  import TextareaMultilang from '~/components/TextareaMultilang'
  import BButton from "bootstrap-vue/src/components/button/button";
  import { Message } from 'element-ui'

  export default {
    layout: 'admin',

    components: {
      BButton,
      TextareaMultilang
    },

    async asyncData({store, params}) {
      return store.dispatch('content/fetchContentForEdit', params.id)
        .then(({data}) => {
          return {
            data: data
          }
        })
    },

    methods: {
      save() {
        this.$store.dispatch('content/saveContent', this.data)
          .then(() => {
            Message.success('Успешное сохранение')
          })
          .catch(() => {
            Message.error('Ошибка сохранения')
          })
      }
    }
  }
</script>
