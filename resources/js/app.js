import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './components/App'
import Home from './components/Home'
import Board from './components/Board'

import './../css/app.css'

import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: 'history',
    routes: [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/:board_href',
        name: 'board',
        component: Board,
        props: true
    },    
	],
})
    
const app = new Vue({
    el: '#app',
    components: { App },
    router,
});