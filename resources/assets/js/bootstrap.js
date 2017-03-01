
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue/dist/vue.js')
require('vue-resource');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next();
});

/** Date Picker **/
import Datepicker from 'vuejs-datepicker';
window.Datepicker = Datepicker;

/** Muliselect dropdown */
import Multiselect from 'vue-multiselect'
window.Multiselect = Multiselect;

/** Editor **/
import Quill from 'quill';
window.Quill = Quill;

/** Notifications **/
import VueNotifications from 'vue-notifications'
import miniToastr from 'mini-toastr'

const toastTypes = {  success: 'success', error: 'error',  info: 'info', warn: 'warn' }
var config =  { types: toastTypes };
miniToastr.init(config);

function toast ({title, message, type, timeout, cb}) {
  return miniToastr[type](message, title, timeout, cb)
}
const options = {  success: toast, error: toast,info: toast, warn: toast}
window.Vue.use(VueNotifications, options);

/** Google location picker */
window.GOOGLE_AUTOCOMPLETE = {
	'domain': 'https://maps.googleapis.com/maps/api/js',
	'key': 'AIzaSyD7T2ffkCZ8eou8ylORC8C5SkMmWmSxyiM',
	'library' : 'places',
	// google inputs retrieved.
	'inputs': {
		administrative_area_level_1: 'long_name',
		street_number: 'short_name',
		postal_code: 'short_name',
		sublocality_level_1: 'long_name',
		neighborhood: 'long_name',
		locality: 'long_name',
		country: 'long_name',
		route: 'long_name'
	}
};

/** Pulse loaders **/
var BounceLoader= require('vue-spinner/dist/vue-spinner.min').BounceLoader;
window.BounceLoader = BounceLoader;

/** Date picker **/
import myDatepicker from 'vue-datepicker'
window.myDatepicker = myDatepicker;

window.bus = new Vue({});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
//
require('./widgets/bootstrap');
require('./forms/bootstrap');
