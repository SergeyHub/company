import Vue from 'vue'
import VeeValidate from 'vee-validate'
import { Validator } from 'vee-validate'

const dictionary = {
  en: {
    attributes: {
      real_name: 'Real Name'
    }
  },
  ru: {
    attributes: {
      real_name: 'настоящее имя'
    }
  }
};

Validator.localize(dictionary);

const multilangValidator = {
  getMessage(field, args) {
    let min = args.length ? args[0] : null;
    let max = args.length ? args[1] : null;
    return  'Field ' + field + ' is incorrect.'
      + (min ? ' Min length - ' + min + ' characters.' : '')
      + (max ? ' Max length - ' + max + ' characters.' : '');
    /*return  'Поле ' + field + ' заполнено некорректно.'
      + (min ? ' Минимальная длина - ' + min + ' символов.' : '')
      + (max ? ' Максимальная длина - ' + max + ' символов.' : '');*/
  },
  validate(value, { min, max } = { }) {
    var locales = Object.keys(value);
    for(let i=0;i<locales.length;i++) {
      let locale_value = value[locales[i]];
      let length_min_validate = locale_value && (!min || (min && locale_value.length >= min));
      let length_max_validate = locale_value && (!max || (max && locale_value.length <= max));
      if(length_min_validate && length_max_validate)
        return true;
    }
    return false;
  }
};

const paramNames = ['min', 'max'];

Validator.extend('multilang', multilangValidator, {paramNames});

const onlyEnglishValidator = {
  getMessage(field) {
    return 'Поле ' + field + ' должно содержать только английские буквы'
  },
  validate(value) {
    return /^[a-zA-Z\s]+$/.test(value)
  }
}

Validator.extend('english', onlyEnglishValidator);


Vue.use(VeeValidate, {
  // This is the default
  inject: true,
  // Important to name this something other than 'fields'
  fieldsBagName: 'veeFields'
})


export default function({ app }) {
  Validator.localize(app.i18n.locale)
}
