/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// import VueRouter from 'vue-router';
// import App from './components/App';
//
// window.Vue.use(VueRouter);
//
// import IngredientsIndex from './components/ingredients/IngredientsIndex.vue';
// import IngredientsCreate from './components/ingredients/IngredientsCreate.vue';
// import IngredientsEdit from './components/ingredients/IngredientsEdit.vue';
//
// var i = 0;
// const routes = [
//     {
//         path: '/ingredients',
//         components: {
//             ingredientsIndex: IngredientsIndex
//         }
//     },
//     {path: '/ingredients/create', component: IngredientsCreate, name: 'createIngredient'},
//     {path: '/ingredients/edit/:id', component: IngredientsEdit, name: 'editIngredient'},
// ]
//
// const router = new VueRouter({ routes, mode: 'history' });
//
// const app = new Vue({ router, render: h => h() }).$mount('#app')
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('pizzas-component', require('./components/pizzas/PizzasIndex.vue').default);
Vue.component('pizza-create-component', require('./components/pizzas/PizzasCreate.vue').default);
Vue.component('ingredient-create-component', require('./components/ingredients/IngredientsCreate.vue').default);
Vue.component('ingredient-edit-component', require('./components/ingredients/IngredientsEdit.vue').default);
Vue.component('pizza-edit-component', require('./components/pizzas/PizzasEdit.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
