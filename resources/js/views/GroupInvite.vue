<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card w-100">
                    <div class="card-body">
                        <h5 class="card-title">Group invitation</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <b>{{ data.group.owner.name }}</b> ({{
                                data.group.owner.email
                            }}) has been invited you to group
                            <b>{{ data.group.full_name }}</b
                            >.
                        </h6>
                        <div v-if="!isLoggedIn">
                            <p
                                v-if="data.user_have_account"
                                class="card-text mb-1"
                            >
                                We found out that you have created account with
                                this email. Please log in and you will be able
                                to accept invitation.
                            </p>
                            <p
                                v-if="!data.user_have_account"
                                class="card-text mb-1"
                            >
                                Hello we see you here first time, if you want
                                join to Partup team, first you have to register
                                account. Click button below that will redirect
                                you to registration from, and then you will have
                                to accept invitation.
                            </p>
                            <a
                                href="#"
                                class="btn btn-primary"
                                @click="redirect"
                                >{{
                                    data.user_have_account
                                        ? "Login"
                                        : "Register"
                                }}</a
                            >
                        </div>
                        <div v-if="isLoggedIn">
                            <p class="card-text mb-1">
                                You need to accept this message then you will be
                                redirected to your home page, but group will be
                                attached to your accout.
                            </p>
                            <a
                                href="#"
                                class="btn btn-primary"
                                @click="sendAccept"
                                >Accept</a
                            >
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
            isLoggedIn: window.sessionStorage.getItem("authUser"),
            inviteHash: this.$route.query.hash,
            data: null,
        };
    },
    created() {
        if (this.inviteHash) {
            this.getInvite();
        }
    },
    methods: {
        getInvite() {
            this.$http
                .get("/v1/group-invitations?hash=" + this.inviteHash)
                .then((result) => {
                    this.data = result.data;
                    this.isLoggedIn=window.sessionStorage.getItem("authUser");
                })
                .catch((err) => {
                    this.$router.push({ name: "Home" });
                });
        },
        redirect(e) {
            e.preventDefault();
            this.$router.push({
                name: this.data.user_have_account ? "Login" : "Register",
                query: { inviteHash: this.inviteHash },
            });
        },
        sendAccept() {
            this.$http
                .post("/v1/group-invitations/accept?hash=" + this.inviteHash)
                .then((result) => {
                    this.$router.push({ name: "StudentZone" });
                })
                .catch((err) => {
                    //TODO: write error handler
                });
        },
    },
};
</script>

<style></style>
