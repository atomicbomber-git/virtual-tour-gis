require('./bootstrap');
window.Vue = require('vue');

Vue.component('location-index', require('./components/location/Index.vue').default);
Vue.component('location-create', require('./components/location/Create.vue').default);
Vue.component('layer-index', require('./components/LayerIndex.vue').default);
Vue.component('location-panorama-index', require('./components/location/panorama/Index.vue').default);
Vue.component('guest-virtual-tour', require('./components/GuestVirtualTour.vue').default);
Vue.component('street-view', require('./components/StreetView.vue').default);

// Import vue-js-modal
import VModal from 'vue-js-modal'
Vue.use(VModal, {dialog: true})

// Import vue2-google-maps
import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
    load: {
        libraries: ["geometry"],
        key: 'AIzaSyCt1SXMaJ-9Yb7xley_wWlvi54f5ckafOQ'
    },
})

window.swal = require('sweetalert')
require('tinymce');
window.tinymce_config = require('./tinymce_config')
window.tinymce_file_picker_callback = require('./tinymce_file_picker_callback.js')

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
    }
});

const app = new Vue({
    el: '#app'
});
