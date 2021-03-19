let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let logout = require('./components/auth/logout.vue').default;
let forget = require('./components/auth/forget.vue').default;
let home = require('./components/home.vue').default;

let employee = require('./components/employee/index.vue').default;
let createEmployee = require('./components/employee/create.vue').default;
let editEmployee = require('./components/employee/edit.vue').default;

let supplier = require('./components/supplier/index.vue').default;
let createSupplier = require('./components/supplier/create.vue').default;
let editSupplier = require('./components/supplier/edit.vue').default;

let category = require('./components/category/index.vue').default;
let createCategory = require('./components/category/create.vue').default;
let editCategory = require('./components/category/edit.vue').default;

export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/home', component: home, name: 'home' },
    { path: '/logout', component: logout, name: 'logout' },

    { path: '/employee', component: employee, name: 'employee' },
    { path: '/employee/create', component: createEmployee, },
    { path: '/employee/edit/:id', component: editEmployee, name: 'editEmployee'},

    { path: '/supplier', component: supplier, name: 'supplier' },
    { path: '/supplier/create', component: createSupplier, },
    { path: '/supplier/edit/:id', component: editSupplier, name: 'editSupplier'},

    { path: '/category', component: category, name: 'category' },
    { path: '/category/create', component: createCategory, },
    { path: '/category/edit/:id', component: editCategory, name: 'editCategory'},
  ]