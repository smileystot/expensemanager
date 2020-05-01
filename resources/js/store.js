import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
export default new Vuex.Store({
    state: {
        rules:{
            required: [
                v => !!v || 'Field is required'
            ],
            email:[
                v => !!v || 'Field is required',
                v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
            ],
            amount:[
                v => !!v || 'Field is required',
                v => (!isNaN(parseFloat(v)) && v >= 0 && v <= 999) || 'Incorrect Amount'
            ] 
        },
        loading: false,
        reports: [],
        roles: [],
        users: [],
        categories: [],
        expenses: []
    },
    
    getters: {
    },
    actions: {
        /*----- Dashboard ----- */
        getReports(context){
            context.commit('getReports')
        },
        /*----- Roles ----- */
        getRoles(context){
            context.commit('getRoles')
        },
        /*----- Users ----- */
        getUsers(context){
            context.commit('getUsers')
        },
        /*----- Categories ----- */
        getCategories(context){
            context.commit('getCategories')
        },
        /*----- Expenses ----- */
        getExpenses(context){
            context.commit('getExpenses')
        },
        
    },
    mutations: {
        /*----- Dashboard ----- */
        getReports(state){
            state.loading = true
            axios.get('/api/reports',)
            .then(response =>{
                state.reports = response.data
                state.loading = false
            })
            .catch(error =>{
                console.log(error)
            })
        },
        /*----- Roles ----- */
        getRoles(state){
            state.loading = true
            axios.get('/api/roles',)
            .then(response =>{
                state.roles = response.data
                state.loading = false
            })
            .catch(error =>{
                console.log(error)
            })
        },
        /*----- Users ----- */
        getUsers(state){
            state.loading = true
            axios.get('/api/users',)
            .then(response =>{
                state.users = response.data
                state.loading = false
            })
            .catch(error =>{
                console.log(error)
            })
        },
        /*----- Categories ----- */
        getCategories(state){
            state.loading = true
            axios.get('/api/categories',)
            .then(response =>{
                state.categories = response.data
                state.loading = false
            })
            .catch(error =>{
                console.log(error)
            })
        },
        /*----- Expenses ----- */
        getExpenses(state){
            state.loading = true
            axios.get('/api/expenses',)
            .then(response =>{
                state.expenses = response.data
                state.loading = false
            })
            .catch(error =>{
                console.log(error)
            })
        },
    }
        
})

