import Vue from 'vue'

Vue.mixin({
  methods: {
    asset(uri) {
      return process.env.cdn_assets + uri
    }
  },
  data() {
    return {
      cdn_assets_prefix: process.env.cdn_assets
    }
  }
})
