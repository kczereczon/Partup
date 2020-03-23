<template>
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center">
            <div
                class="align-middle offset-lg-3 offset-md-2 offset-sm-0 col-lg-6 col-md-8 col-sm-12"
            >
                <div class="card card-block">
                    <div class="row no-gutters">
                        <div class="col-md-12">
                            <div class="card-body">
                                <h5 class="card-title">Sign in</h5>
                                <div v-if="message" id="error">
                                    <Error :error="message" />
                                </div>
                                <form @submit="formSubmit">
                                    <input-component
                                        label="Email"
                                        id="email"
                                        name="email"
                                        type="text"
                                        v-model="email"
                                        placeholder="example@gmail.com"
                                        :error="errors['email']"
                                    />
                                    <input-component
                                        label="Password"
                                        id="password"
                                        name="password"
                                        type="password"
                                        v-model="password"
                                        placeholder="eg. Min 6 charas with specials."
                                        :error="errors['password']"
                                    />
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <button class="custom-btn w-100">
                                                LOGIN
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <router-link :to="'/register'">
                                                <button
                                                    class="custom-btn w-100"
                                                >
                                                    REGISTER
                                                </button>
                                            </router-link>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Error from "../components/Error.vue";

export default {
    components: {
        Error
    },
    data() {
        return {
            email: "",
            password: "",
            output: "",
            hideAlert: true,
            errors: {},
            message: null
        };
    },
    created() {},
    ready: function() {
        if (window.localStorage.getItem("authToken"))
            this.$router.push({ name: "Home" });
    },
    methods: {
        formSubmit(e) {
            e.preventDefault();
            let currentObj = this;

            currentObj.errors = {};
            currentObj.message = "";

            axios
                .post("/api/v1/login", {
                    email: this.email,
                    password: this.password
                })
                .then(function(response) {
                    window.localStorage.setItem(
                        "authUser",
                        JSON.stringify(response.data.user)
                    );
                    window.localStorage.setItem(
                        "authToken",
                        response.data.access_token
                    );

                    axios.defaults.headers.common["Authorization"] =
                        "Bearer " + response.data.access_token;

                    currentObj.output = response.data;
                    this.$router.push({ name: "Home" });
                })
                .catch(function(error) {
                    currentObj.output = error;
                    currentObj.errors = error.response.data.errors
                        ? error.response.data.errors
                        : {};
                    currentObj.message = error.response.data.message;
                });
        }
    }
};
</script>
<style lang="scss">
.custom-btn {
    border: none;
    width: 100%;
    padding: 1vh;
    color: white;
    background: linear-gradient(to left, #845ec2, #ff6f91);
    border-radius: 5px;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.4);
}
</style>
