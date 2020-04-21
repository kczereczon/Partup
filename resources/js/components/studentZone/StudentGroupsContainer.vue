<template>
    <div class="row justify-content-center">
        <div class="col-md-11 col-sm-12">
            <div class="card my-3">
                <div class="card-header">
                    Groups
                </div>
                <div class="card-body">
                    <div class="row">
                        <student-groups-component
                            v-for="(group) in groups"
                            v-bind:group="group"
                            :key="group.id"
                        />
                    </div>
                    <loader ref="loader" id="student-group-component" />
                </div>
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
    created() {
        this.getGroups();
    },
    methods: {
        getGroups() {
            this.$http
                .get("v1/user/groups")
                .then(results => {
                    this.groups = results.data;
                })
                .catch(error => console.log(error.response))
                .finally(() => {
                    // The whole view is rendered, so I can safely access or query
                    // the DOM. ¯\_(ツ)_/¯
                    this.$refs["loader"].hide();
                });
        },
    }
};
</script>

<style></style>
