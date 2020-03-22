<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
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
                            v-on:remove="remove(index)"
                            :editMode="group.id ? false : true"
                            v-on:refresh="getGroups"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
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
            axios
                .get("/api/v1/groups", {
                    headers: {
                        Authorization:
                            "Bearer " + window.localStorage.getItem("authToken")
                    }
                })
                .then(results => {
                    console.log(results.data);
                    this.groups = results.data;
                })
                .catch(error => console.log(error.response));
        },
        remove(index) {
            if (this.groups[index].id) {
                axios
                    .delete("/api/v1/groups/" + this.groups[index].id, {
                        headers: {
                            Authorization:
                                "Bearer " +
                                window.localStorage.getItem("authToken")
                        }
                    })
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
