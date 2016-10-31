window._ = require('lodash');

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

window.Vue = require('vue');
require('vue-resource');

window.Tribute = require('tributejs');

require('./helpers');

Vue.http.options.root = '/api/v1';

Vue.http.interceptors.push(function(request, next) {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

    next();
});

window.bus = new Vue();