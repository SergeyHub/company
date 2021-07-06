import { Message } from 'element-ui'

export default function ({ $axios, app, redirect, req, store }) {

  let original_host = req ? req.headers.host.split(':')[0] : window.location.host.split(':')[0];

  let host = original_host;

  //if (process.env !== 'production')
   // host = host + ':81';
 // }

  host = process.env.base_domain

  let protocol = 'http';


  if(process.env.production) {
    protocol = 'https';
  }

  $axios.apiUrl = protocol + '://' + host + '/api';
  $axios.defaults.baseURL = protocol + '://' + host + '/api';
  $axios.defaults.timeout = 25000;

  $axios.onRequest(config => {

    // добавляем параметр языка ко всем запросам
    if(!config.params)
      config.params = {};
    config.params.lang = app.i18n.locale;

    if(!config.headers)
      config.headers = {};
    config.headers['Authorization'] = 'Bearer ' + store.state.auth.token;

    if(process.server) {
      config.headers['SecretHost'] = original_host;
    }

    return config;
  });

  $axios.onError(error => {
    const code = parseInt(error.response && error.response.status);
    if (code === 422 && error.response.data.errors) {
      var errors = error.response.data.errors;
      Message.error({
        message: errors[Object.keys(errors)[0]][0],
        showClose: true
      })
    }
  })
}
