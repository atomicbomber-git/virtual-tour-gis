require('./bootstrap');
window.Vue = require('vue');

Vue.component('location-index', require('./components/location/Index.vue').default);
Vue.component('location-create', require('./components/location/Create.vue').default);
Vue.component('location-panorama-index', require('./components/location/panorama/Index.vue').default);
Vue.component('guest-virtual-tour', require('./components/GuestVirtualTour.vue').default);
Vue.component('street-view', require('./components/StreetView.vue').default);

// Import vue2-google-maps
import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyBDzI0csQYqh24xwIyl_-rlKynmiam4DGU'
    },
})

// Import vue-js-modal
import VModal from 'vue-js-modal'

Vue.use(VModal, { dialog: true })

const app = new Vue({
    el: '#app'
});
