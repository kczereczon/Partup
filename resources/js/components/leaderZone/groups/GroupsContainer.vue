<template>
    <div class="row justify-content-center">
        <div class="col-md-11 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="mt-auto mb-auto col-6">Groups</div>
                        <div class="col-6 text-right">
                            <a v-on:click="addNewGroup()" class>
                                <span class="fa fa-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <group-component
                        v-for="(group, index) in groups"
                        :key="group.id"
                        :id="group.id"
                        :name="group.name"
                        :subgroups="group.subgroups"
                        :class="{ 'mt-3': index != 0 }"
                        :homework_webhook="group.homework_webhook"
                        :exams_webhook="group.exams_webhook"
                        :news_webhook="group.news_webhook"
                        v-on:remove="remove(index)"
                        :editMode="group.id ? false : true"
                        v-on:refresh="getGroups"
                    />
                    <loader ref="loader" id="group-component" />
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
            this.groups = null;
            this.$http
                .get("/v1/groups")
                .then(results => {
                    console.log(results.data);
                    console.log('zeruje tabelke');
                    this.groups = results.data;
                })
                .catch(error => console.log(error.response))
                .finally(() => {
                    // The whole view is rendered, so I can safely access or query
                    // the DOM. ¯\_(ツ)_/¯
                    this.$refs["loader"].hide();
                });
        },
        remove(index) {
            if (this.groups[index].id) {
                this.$http
                    .delete("/v1/groups/" + this.groups[index].id)
                    .then(results => {
                        this.groups.splice(index, 1);
                        this.getGroups();
                    })
                    .catch(error => console.log(error.response));
            } else {
                this.groups.splice(index, 1);
            }
        }
    }
};
</script>

<style></style>
