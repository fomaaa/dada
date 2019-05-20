// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

var VueCookie = require('vue-cookie');
// Tell Vue to use the plugin
Vue.use(VueCookie);

Vue.config.productionTip = false;

import Vuebar from 'vuebar';
import VueScrollTo from 'vue-scrollto';
import VueGtm from 'vue-gtm';
import VueRouter from 'vue-router';
import Footer from './components/Footer/Footer';
import Header from './components/Header/Header';
import HeaderMini from './components/Header-Mini/Header-Mini';
import Logo from './components/Logo/Logo';
import InfiniteLoading from 'vue-infinite-loading';
import VueResource from 'vue-resource';

const {detect} = require('detect-browser');
const browser = detect();
window.urlLang = location.pathname.split('/')[1];
window.isru = window.urlLang === 'ru';

// register globally
Vue.component('footer-block', Footer);
Vue.component('header-block', Header);
Vue.component('header-mini', HeaderMini);
Vue.component('logo-block', Logo);
Vue.component('infinite-loading', InfiniteLoading);

// Vue.use(VueGtm, {
// 	enabled: true, // defaults to true. Plugin can be disabled by setting this to false for Ex: enabled: !!GDPR_Cookie (optional)
// 	debug: true, // Whether or not display console logs debugs (optional)
// 	vueRouter: vueRouter, // Pass the router instance to automatically sync with router (optional)
// 	// ignoredViews: ['homepage'] // If router, you can exclude some routes name (case insensitive) (optional)
// });
Vue.use(VueResource);

Vue.use(VueScrollTo, {
  container: "#container-scroll-js",
  duration: 500,
  easing: "ease",
  offset: 0,
  x: false,
  y: true
});
Vue.use(Vuebar);

new Vue({
  router,
  el: '#app',
  render: h => h(App),
  mounted() {
    $(document).on({
      mouseenter: function () {
        let self = $(this);
        $('#cursor').addClass('showing-text');
        $('.cursor__text').html(self.data('cursor'));

        if (self.data('cursor-color') === 'black') {
          $('#cursor').addClass('color-black');
        }

        if (self.data('cursor-color') === 'white') {
          $('#cursor').addClass('color-white');
        }
      },
      mouseleave: function () {
        $('#cursor').removeClass('showing-text color-white color-black');
      }
    }, "[data-cursor]");
  }
  // components: {
  // 	App
  // },
  // template: '<App/>',

});


// const vueRouter = new VueRouter({ routes, mode, linkActiveClass });

Vue.use(VueGtm, {
  enabled: true, // defaults to true. Plugin can be disabled by setting this to false for Ex: enabled: !!GDPR_Cookie (optional)
  debug: false, // Whether or not display console logs debugs (optional)
//     vueRouter: vueRouter, // Pass the router instance to automatically sync with router (optional)
//     // ignoredViews: ['homepage'] // If router, you can exclude some routes name (case insensitive) (optional)
});

import '@fancyapps/fancybox';

const cursor = document.getElementById('cursor');

document.addEventListener("mousemove", function (e) {
  cursor.style.top = e.y + "px";
  cursor.style.left = e.x + "px";

  if ($(e.target).is('canvas')) {
    $('#cursor').addClass('is-hidden')
  }
});


document.addEventListener('click', function () {
  $('#cursor').addClass('is-clicked')
  setTimeout(() => $('#cursor').removeClass('is-clicked'), 150);
});
