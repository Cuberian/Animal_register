import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        auth: {
            login: false,
            role: {},
            user: {}
        },
    },

    getters: {
       isLoggedIn(state) {
           return state.auth.login;
       },
       getRole(state) {
         return state.auth.role;
       }
    },

    mutations: {
        LOGIN(state, status) {
            state.auth.login = status;
        },
        AUTH_USER(state, user) {
            state.auth.user = user;
            state.auth.role = user.role;
        }
    },

    actions: {}
})
