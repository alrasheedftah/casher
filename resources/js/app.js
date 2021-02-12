/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// global.$ = global.jQuery = require('jquery');
window.Vue = require('vue');


require('bootstrap-table/dist/bootstrap-table')

require('tableexport.jquery.plugin')
require('bootstrap-table/dist/extensions/export/bootstrap-table-export')
require('bootstrap-table/dist/extensions/print/bootstrap-table-print')

require('bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control')

import DataTable from '@andresouzaabreu/vue-data-table'
Vue.component("data-table", DataTable)




import {Form ,HasError,AlertError} from 'vform';
import moment from "moment";
import routes from './routes'

import Swal from 'sweetalert2'

window.Swal=Swal

import Gate from "./Gate";
Vue.prototype.$gate=new Gate(window.user)


/// import restoran components 
import ProductsGrid from 'vue-products-grid'

////   Vue Printer 
import VueHtmlToPaper from 'vue-html-to-paper';
const options = {
    name: '_blank',
    specs: [
      'fullscreen=yes',
      'titlebar=yes',
      'scrollbars=yes'
    ],
    styles: [
      '/css/app.css',
      '/css/Print.css'
    ]
  }
Vue.use(VueHtmlToPaper, options);
////    Vue Printer 

window.Fire=new Vue()


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.Toast=Toast


window.Form=Form;
Vue.component(HasError.name,HasError)
Vue.component(AlertError.name,AlertError)

import VueRouter from 'vue-router'
Vue.use(VueRouter)
/// progress bar vue
import vueProgressBar from 'vue-progressbar'
Vue.use(vueProgressBar,{
    color:'rgb(143,255,199)',
    failedColor:'red',
    hieght:'3px'
})

const router=new VueRouter({
    // base: '/makank/Anti_Covid19/public/',
    mode:'history',
    routes
})




Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase()+text.slice(1)
    //text.toUpperCase();
})


Vue.filter('myDate',function(date){
    return moment(date).format("MMMMM Do YYYY")
    //text.toUpperCase();
})



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//  Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination',require('laravel-vue-pagination'))


/// Passport Client Components /////
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);




Vue.component('not-found',require('./components/NotFount').default)
// Vue.component('vue-products-grid',require('vue-products-grid').default)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,

    data:{
        search:''
    },
    methods:{
        searchit:_.debounce(()=>{ // to wait evry 1 second then send request
            Fire.$emit("Searching")
        },1000),

        printPDF(){
            window.print()
        }
    }

});
