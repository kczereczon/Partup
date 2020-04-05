<template>
    <div class="row justify-content-center">
        <div class="col-md-11 col-sm-12">
            <div class="card my-3">
                <div class="card-header">
                    Groups
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <student-groups-component
                                v-for="(group) in groups"
                                :key="group.id"
                                :id="group.id"
                                :name="group.name"
                            />
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
            groups: []
        };
    },
    created() {
        this.getGroups();
    },
    methods: {
        addNewGroup() {
            if (this.groups[0] == undefined || this.groups[0].id) {
                this.groups.unshift({});
            }
        },
        getGroups() {
            this.$http
                .get("/v1/groups")
                .then(results => {
                    console.log(results.data);
                    this.groups = results.data;
                })
                .catch(error => console.log(error.response));
        }
    }
};
</script>

<style></style>
