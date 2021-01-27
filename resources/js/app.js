/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import {  ValidationProvider, ValidationObserver } from 'vee-validate';

import vuetify from './plugins/vuetify'
import 'sweetalert2/src/sweetalert2.scss'

import { required, digits, email, max, regex, min_value } from 'vee-validate/dist/rules'
import { extend, setInteractionMode } from 'vee-validate'

setInteractionMode('eager')

extend('digits', {
    ...digits,
    message: '{_field_} needs to be {length} digits. ({_value_})',
})

extend('required', {
    ...required,
    message: 'Данное поле должно быть заполнено',
})

extend('max', {
    ...max,
    message: '{_field_} may not be greater than {length} characters',
})

extend('regex', {
    ...regex,
    message: '{_field_} {_value_} does not match {regex}',
})

extend('email', {
    ...email,
    message: 'Email must be valid',
})

extend('min_value', {
    ...min_value,
    message: 'Значение поле не может быть меньше чем {min}',
})

extend('min_date', {
    validate(value, args) {
        console.log('Im here');
        let d_value = new Date(value)
        let d_min = new Date(args.min)
        console.log(d_value);
        console.log(d_min);
        return d_value >= d_min;
    },
    params: ['min'],
    message: 'Дата не может быть установлена раньше чем {min}'
});

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('add-card', require('./components/Card/AddCard.vue').default);
Vue.component('edit-card', require('./components/Card/EditCard.vue').default);
Vue.component('animal-card', require('./components/Card/ShowCard.vue').default);

Vue.component('register', require('./components/Register/Register.vue').default);

Vue.component('navbar', require('./components/Navbar.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify
});
