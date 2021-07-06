import Vue from 'vue';
import VueIntercom from 'vue-intercom'

Vue.use(VueIntercom, {
  appId: process.env.intercom_app_id
});
