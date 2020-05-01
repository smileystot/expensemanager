import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import Dashboard from './components/Dashboard'
import Roles from './components/Roles'
import Users from './components/Users'
import Categories from './components/Categories'
import Expenses from './components/Expenses'
import Page404 from './components/Page404' 

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'dashbord',
            component: Dashboard
        },
        {
            path: '/roles',
            name: 'roles',
            component: Roles
        },
        {
            path: '/users',
            name: 'users',
            component: Users
        },
        {
            path: '/categories',
            name: 'categories',
            component: Categories
        },
        {
            path: '/expenses',
            name: 'expenses',
            component: Expenses
        },
        {
            path: '*',
            component: Page404
        },
    ]
})