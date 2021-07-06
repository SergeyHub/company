import en from 'vee-validate/dist/locale/en'
import ru from 'vee-validate/dist/locale/ru'
import Vue from 'vue'
import 'dayjs/locale/ru'
import 'dayjs/locale/en'
import dayjs from 'dayjs'
import { Validator } from 'vee-validate'
import { EventBus } from '~/utils/event-bus'

Vue.mixin({
  methods: {
    getLocaleValue: function (object) {
      if(object[this.$i18n.locale] && object[this.$i18n.locale].length)
        return object[this.$i18n.locale];
      return object['en'];
    }
  }
});

export default function ({ app }) {

  Validator.localize('en', en)
  Validator.localize('ru', ru)
  dayjs.locale(app.i18n.locale)

  // Localizing the app when user refresh or access a localized link
  Validator.localize(app.i18n.loadedLanguages[0]);

  // beforeLanguageSwitch called right before setting a new locale
  app.i18n.beforeLanguageSwitch = (oldLocale, newLocale) => {
    Validator.localize(newLocale)
  };

  // onLanguageSwitched called right after a new locale has been set
  app.i18n.onLanguageSwitched = (oldLocale, newLocale) => {
    dayjs.locale(newLocale);

    EventBus.$emit('langChanged');

    if(app.store.state.country) {
      app.store.dispatch('fetchAndSetCountry',  {
        slug: app.store.state.country.slug,
        section: 'girls'
      });
    }

    if(app.store.state.city && app.store.state.city.id)
      app.store.dispatch('setCurrentCity', app.store.state.city.slug)

    if(app.store.state.top_countries.length)
      app.store.dispatch('setTopCountries')
    if(app.store.state.countries.length)
      app.store.dispatch('setCountries')
    if(app.store.state.options.eyes.length)
      app.store.dispatch('options/fetchEyes')
    if(app.store.state.options.nationalities.length)
      app.store.dispatch('options/fetchNationalities')
    if(app.store.state.options.hairs.length)
      app.store.dispatch('options/fetchHairs')
    if(app.store.state.options.currencies.length)
      app.store.dispatch('options/fetchCurrencies')
    if(app.store.state.options.languages.length)
      app.store.dispatch('options/fetchLanguages')
    if(app.store.state.options.geographies.length)
      app.store.dispatch('options/fetchGeographies')
    if(app.store.state.options.iLikes.length)
      app.store.dispatch('options/fetchIlikes')
    if(app.store.state.options.readyFor.length)
      app.store.dispatch('options/fetchReadyFor')
    if(app.store.state.options.bodies.length)
      app.store.dispatch('options/fetchBodies')
    if(app.store.state.options.orientations.length)
      app.store.dispatch('options/fetchOrientations')
    if(app.store.state.options.bodyHairs.length)
      app.store.dispatch('options/fetchBodyHairs')
    if(app.store.state.options.ethnicities.length)
      app.store.dispatch('options/fetchEthnicities')
    if(app.store.state.options.purposes.length)
      app.store.dispatch('options/fetchPurposes')
  }
}
