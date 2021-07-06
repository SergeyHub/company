import Vue from 'vue'
import VueAwesomeSwiper from 'vue-awesome-swiper'


require('swiper/swiper-bundle.css')

if (process.client) {
  Vue.use(VueAwesomeSwiper, /* { default options with global component } */)
}
