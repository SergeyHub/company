<template>
  <router-link
    class="post__wrapper"
    :to="localePath({ name: 'articles-slug', params: { slug: article.slug } })">
    <article>
      <figure class="post__image" v-lazy:background-image="article.cover"></figure>
      <div class="post__info">
        <h2 class="post__title">{{ article.title }}</h2>
        <div class="post__data">
          <footer class="post__footer">
            <time class="post__info">{{ date }}</time>
          </footer>
        </div>
      </div>
    </article>
  </router-link>
</template>

<script>

  import dayjs from 'dayjs'
  import LocalizedFormat from 'dayjs/plugin/localizedFormat'
  dayjs.extend(LocalizedFormat)

  export default {
    props: {
      article: {
        required: true,
        type: Object
      }
    },

    computed: {
      date() {
        return dayjs(this.article.created_at).format('LL')
      }
    },

    methods: {
      changeLocale() {
        dayjs.locale('en')
      }
    },

    mounted() {
      setTimeout(() => {
        this.changeLocale()
      }, 2000)
    }
  }
</script>
