/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import VueRouter from "vue-router";
import Login from "./views/Login";
import Register from "./views/Register";
import Home from "./views/Home";
import VueAxios from "vue-axios";
import axios from "axios";
import API from "./api";

Vue.use(VueRouter, VueAxios, axios);

const routes = [
    { path: "/", name: "Home", component: Home },
    { path: "/register", name: "Register", component: Register },
    { path: "/login", name: "Login", component: Login }
];

const router = new VueRouter({
    mode: "history",
    routes
});

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

Vue.prototype.$http = API;

const app = new Vue({
    router
}).$mount("#app");
