/*import Vue from 'vue'
import Datepicker from 'vuejs-datepicker'

Vue.component('date-picker', Datepicker)
*/
/*
import Vue from 'vue'
import VueFlatPickr from 'vue-flatpickr-component';

import 'flatpickr/dist/themes/dark.css';

const flatPickrLangs = {
  ru: require("flatpickr/dist/l10n/ru.js").default.ru,
  en: require("flatpickr/dist/l10n/default.js").default
};

//const English = require("flatpickr/dist/l10n/default.js").default.english
//flatpickr.localize(English);


Vue.component('date-picker', VueFlatPickr)

export default function({ app }) {
  flatpickr.localize(flatPickrLangs[app.i18n.locale])
}
*/
import Vue from 'vue';
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
import AppDatePicker from '~/components/Datepicker'


// Register components in your 'main.js'
Vue.component('v-date-picker', DatePicker)


Vue.component('date-picker', AppDatePicker)
