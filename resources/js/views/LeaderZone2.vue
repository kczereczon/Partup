<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12 pb-3 pt-3">
                <leader-groups-container :groups="groups" @refresh="getGroups()" />
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            groups: []
        };
    },
    mounted() {
        this.getGroups();
    },
    methods: {
        getGroups() {
            this.$http
                .get("/v1/groups/all")
                .then(results => {
                    this.groups = results.data;
                    window.sessionStorage.clear("leaderGroups");
                })
                .catch(error => {
                    console.log(error.response);
                });
        }
    }
};
</script>

<style></style>
