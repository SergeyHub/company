import Modal from './modal.vue'

const CityModal = {
  // every plugin for Vue.js needs install method
  // this method will run after Vue.use(<your-plugin-here>) is executed
  install(Vue, options) {
    // We must create new Eventbus
    // which is just another Vue instance that will be listening for and emiting events from our main instance
    // this EventBus will be available as Modal.EventBus
    this.EventBus = new Vue();

    // making our modal component global
    Vue.component('city-modal', Modal);

    // exposing global $modal object with method show()
    // method show() takes object params as argument
    // inside this object we can have modal title, text, styles... and also our callback confirm function
    Vue.prototype.$cityModal = {
      open(params={}) {
        CityModal.EventBus.$emit('open', params)
      }
    }
  }
}

export default CityModal
