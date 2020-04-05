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
import StudentZone from "./views/StudentZone";
import TeacherZone from "./views/TeacherZone";
import LeaderZone from "./views/LeaderZone";
import VueAxios from "vue-axios";
import axios from "axios";
import API from "./api";

Vue.use(VueRouter, VueAxios, axios);

const routes = [
    {
        path: "/",
        name: "Home",
        meta: {
            requiresAuth: true,
        },
        component: Home,
    },
    { path: "/register", name: "Register", component: Register },
    { path: "/login", name: "Login", component: Login },
    { path: "/student-zone", name: "StudentZone", component: StudentZone },
    { path: "/teacher-zone", name: "TeacherZone", component: TeacherZone },
    { path: "/leader-zone", name: "LeaderZone", component: LeaderZone },
];

const routerObject = new VueRouter({
    routes,
    linkActiveClass: "active",
});

routerObject.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!window.localStorage.getItem("authToken")) {
            next({ name: "Login" });
            $root.isLogged = false;
        } else {
            next(); // go to wherever I'm going
        }
    } else {
        next(); // does not require auth, make sure to always call next()!
    }
});

const files = require.context("./", true, /\.vue$/i);
files
    .keys()
    .map((key) =>
        Vue.component(key.split("/").pop().split(".")[0], files(key).default)
    );

Vue.prototype.$http = API;

const app = new Vue({
    el: "#app",
    router: routerObject,
    data: {
        isLogged: window.localStorage.getItem("authToken"),
    },
    methods: {
        logout() {
            this.isLogged = false;
            window.localStorage.removeItem("authToken");
            window.localStorage.removeItem("authUser");
            this.$router.push({ name: "Login" });
        },
    },
});
