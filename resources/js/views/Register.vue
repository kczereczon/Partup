<template>
    <div>
        <div class="container-fluid h-100">
            <div class="row h-100 align-items-center">
                <div
                    class="align-middle offset-lg-4 offset-md-2 offset-sm-0 col-lg-4 col-md-8 col-sm-12"
                >
                    <div class="card card-block">
                        <div class="row no-gutters">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <h5 class="card-title">Sign up</h5>
                                    <div v-if="message" id="error">
                                        <Error :error="message" />
                                    </div>
                                    <form @submit="formSubmit">
                                        <h4>Creating <b>{{query_email}}</b> user.</h4>
                                        <input-component
                                            label="Name"
                                            id="name"
                                            name="name"
                                            type="text"
                                            v-model="name"
                                            placeholder="John Snow"
                                            :error="errors['name']"
                                        />
                                        <input-component v-if="!query_email"
                                            label="Email"
                                            id="email"
                                            name="email"
                                            v-model="email"
                                            type="text"
                                            placeholder="example@ex.com"
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
                                        <input-component
                                            label="Re-password"
                                            id="re_password"
                                            name="re_password"
                                            type="password"
                                            v-model="re_password"
                                            placeholder="Retype same password from above."
                                            :error="errors['re-password']"
                                        />
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="policy"
                                                id="policy"
                                            />
                                            <label class="form-check-label" for="policy">
                                                Agreement of
                                                <a href>policy</a>.
                                            </label>
                                        </div>
                                        <div class="form-group mt-3">
                                            <button class="custom-btn">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            email: this.$route.query.email,
            password: "",
            re_password: "",
            agreement: "",
            output: null,
            errors: [],
            query_email: this.$route.query.email
        };
    },
    methods: {
        formSubmit(e) {
            e.preventDefault();
            let currentObj = this;
            currentObj.errors = {};
            currentObj.message = "";

            this.$http
                .post("/v1/register", {
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.re_password,
                    name: this.name
                })
                .then(function(response) {
                    currentObj.output = response.data;
                    if (currentObj.$route.query.inviteHash) {
                        currentObj.$router.push({
                            name: "Login",
                            query: {
                                hash: currentObj.$route.query.inviteHash
                            }
                        });
                    } else if (currentObj.$route.query.courseInviteHash) {
                        currentObj.$router.push({
                            name: "Login",
                            query: {
                                hash: currentObj.$route.query.courseInviteHash
                            }
                        });
                    } else currentObj.$router.push({ name: "Login" });
                })
                .catch(function(error) {
                    currentObj.output = error;
                    currentObj.errors = error.response.data.errors;
                    currentObj.message = error.response.data.message;
                });
        }
    }
};
</script>

<style></style>
