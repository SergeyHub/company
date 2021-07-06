<template>
  <nav id="pagination">
    <ul class="page-numbers" v-if="total">
      <li v-for="num in this.pageNumbers" v-if="num != null" v-bind:style="{ width: (100 / pageNumberCount) + '%' }" :key="num">
        <nuxt-link v-if="num != $route.query.page && num != currentPage" :to="{ path: '/', query: { page: num } }">{{ num }}</nuxt-link>
        <span v-else>{{ num }}</span>
      </li>
    </ul>
    <ul class="page-guides" v-if="total != 1">
      <li>
        <nuxt-link v-if="$route.query.page != 1 && $route.query.page" :to="{ path: '/', query: { page: 1 }}">1</nuxt-link>
        <span v-else>1</span>
      </li>
      <li>
        <nuxt-link v-if="this.prevpage != null" :to="{ path: '/', query: { page: this.prevpage }}">&laquo; Prev</nuxt-link>
        <span v-else>&laquo; Prev</span>
      </li>
      <li>
        <nuxt-link v-if="this.nextpage != null && $route.query.page != total" :to="{ path: '/', query: { page: this.nextpage }}">
          Next
        </nuxt-link>
        <span v-else>Next &raquo;</span>
      </li>
      <li>
        <nuxt-link v-if="$route.query.page != total" :to="{ path: '/', query: { page: total }}">Last</nuxt-link>
        <span v-else>Last</span>
      </li>
    </ul>
  </nav>
</template>

<script>
  export default {
    props: {
      total: {
        type: Number,
        default: () => 1
      },
      currentPage: {
        type: Number,
        default: () => 1
      }
    },
    data () {
      return {
        prevpage: null,
        nextpage: null,
        pageNumbers: [],
        pageNumberCount: 0
      }
    },
    mounted () {
      this.setPageNumbers()
    },
    methods: {
      setPages (currentPage, totalPageCount) {
        this.prevpage = currentPage > 1 ? (currentPage - 1) : null
        if (!totalPageCount) {
          this.nextpage = this.$route.query.page ? (parseInt(this.$route.query.page) + 1) : 2
        } else {
          this.nextpage = currentPage < totalPageCount ? (parseInt(currentPage) + 1) : null
        }

        for (let i = 0; i < 7; i++) {
          let _p = ((parseInt(currentPage) - 4) + i)
          if (_p > 0 && _p <= totalPageCount) {
            this.pageNumbers.push(_p)
            this.pageNumberCount++
          } else this.pageNumbers.push(null)
        }
      },
      setPageNumbers () {
        let _currentPage = this.$route.query.page ? this.$route.query.page : 1
        this.currentPage = _currentPage
        this.setPages(_currentPage, this.$store.state.totalPageCount)
      }
    }
  }
</script>
