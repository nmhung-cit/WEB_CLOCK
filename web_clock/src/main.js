import Vue from 'vue'
import App from './App.vue'
//boostrap
import { BootstrapVue } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
//axios
import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios,axios)
//touch envet
// import Vue2TouchEvents from 'vue2-touch-events'
// Vue.use(Vue2TouchEvents)
//vuex
import Vuex from 'vuex'
import Store from './vuex/index'
Vue.use(Vuex)
const store = new Vuex.Store(Store)
// use vue router
import VueRouter from 'vue-router'
import routes from './vue_router/index'
const router = new VueRouter(
  {
    mode:'history',
    routes,
  }
)
Vue.use(VueRouter)

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
  store
}).$mount('#app')
