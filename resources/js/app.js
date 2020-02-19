require('./bootstrap');
import 'es6-promise/auto'
import axios from 'axios'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Buefy from 'buefy'
import Index from './Index'
//import AppBar from '../views/AppBar'
import auth from './auth'
import router from './router'
import '../../node_modules/bulma/css/bulma.min.css'
import 'buefy/dist/buefy.css'


// Set Vue globally

window.Vue = Vue
// Set Vue router
Vue.router = router
Vue.use(VueRouter)
// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`
Vue.use(VueAuth, auth)
Vue.use(Buefy)


// Load App
Vue.component('Index', Index)

const app = new Vue({
  el: '#app',
  router
});
