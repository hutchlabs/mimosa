
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/Welcome.vue');
require('./components/Home.vue');
require('./components/Stats.vue');
require('./components/Users.vue');
require('./components/Organizations.vue');
require('./components/Permissions.vue');
require('./components/Badges.vue');
require('./components/Plans.vue');
require('./components/Screening.vue');
require('./components/Events.vue');
require('./components/Themes.vue');
require('./components/Jobs.vue');

window.bus = new Vue({});

const app = new Vue({
    el: '#app',

    components: {
        'notifications': Notification,
    },

    data: {

    }
});

