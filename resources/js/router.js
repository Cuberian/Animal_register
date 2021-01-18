import VueRouter from 'vue-router'
import Register from "./components/Register/Register";


export default new VueRouter({
    routes: [
        {
            path: '/register',
            component: Register
        }
    ],
    mode: 'history'
})
