require('./bootstrap');

const routes = require('./routes');

var VueRouter = require('vue-router');

Vue.component('app', require('./components/app.vue'));

Vue.filter('firstLetter', function(value) {
	if (value) return value[0].toUpperCase();
});

const router = new VueRouter({
	routes: routes.routes
});

const app = new Vue({
	router
}).$mount('#app');