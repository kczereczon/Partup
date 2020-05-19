<template>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8 col-sm-12 pb-3 pt-3" v-if="!loading">
            <div class="card">
                <div class="card-header">
                    <group-view-header
                        :group="group"
                        :key="'h'+group.id"
                        :shouldShowGroupData="shouldShowGroupData"
                        @refresh="getGroup()"
                        @changeShowGroupData="changeShowGroupData()"
                    />
                </div>
                <div class="card-body" v-if="shouldShowGroupData">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8 align-self-center">Subgroups</div>
                                <div class="col-4 text-right align-self-center">
                                    <a class="ml-1" @click="createGroup()">
                                        <span class="fa fa-plus"></span>
                                    </a>
                                    <a
                                        @click="removeGroup()"
                                        v-if="this.group.subgroups.length!=0"
                                        class="ml-1"
                                    >
                                        <span class="fa fa-minus"></span>
                                    </a>
                                    <a
                                        class="ml-1"
                                        @click="changeShowSubgroups()"
                                        v-if="this.group.subgroups.length!=0"
                                    >
                                        <span
                                            :class="{
                                        'fa fa-caret-down': !shouldShowSubgroups,
                                        'fa fa-caret-up': shouldShowSubgroups
                                    }"
                                        ></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card-body"
                            v-if="shouldShowSubgroups && this.group.subgroups.length!=0"
                        >
                            <button
                                type="button"
                                class="btn btn-link bg-light px-4 my-2 mx-3"
                                style="border:1px solid rgba(0, 0, 0, 0.125)"
                                v-for="(groups) in group.subgroups"
                                :key="'g'+groups.id"
                                v-on:click="redirectToGroup(groups.id)"
                            >
                                <h5 class="my-0">{{groups.name}}</h5>
                            </button>
                        </div>
                    </div>
                    <br />
                    <loader v-if="loading" />
                    <group-view-courses :group="this.group" @refresh="refresh()" />
                    <br />
                    <group-view-students-invitations :group="this.group" @refresh="refresh()" />
                    <br />
                    <group-view-students-list :group="this.group" @refresh="refresh()" />
                    <br />
                </div>
            </div>
            <br />
        </div>
    </div>
</template>
<script>
import Swal from "sweetalert2";
export default {
    data() {
        return {
            group: [],
            shouldShowSubgroups: true,
            shouldShowGroupData: true,
            loading: true
        };
    },
    mounted() {
        if (!window.sessionStorage.leaderGroups)
            this.refresh();
        else
            this.getGroup();
    },
    methods: {
        getGroup() {
            if (
                JSON.parse(window.sessionStorage.leaderGroups)[
                    this.$route.params.id
                ]
            ) {
                this.group = JSON.parse(window.sessionStorage.leaderGroups)[
                    this.$route.params.id
                ];
                this.loading = false;
            } else this.$router.push({ name: "LeaderZone" });
        },
        redirectToGroup(idGrupy) {
            this.$router.push({ name: "GroupView", params: { id: idGrupy } });
            this.getGroup();
        },
        changeShowSubgroups() {
            this.shouldShowSubgroups = !this.shouldShowSubgroups;
        },
        changeShowGroupData() {
            this.shouldShowGroupData = !this.shouldShowGroupData;
        },
        createGroup() {
            Swal.fire({
                title: "Creating a new subgroup for " + this.group.name,
                text: "Group Name",
                input: "text",
                showCancelButton: true,
                confirmButtonText: "Create new Group",
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                scrollbarPadding: false
            }).then(result => {
                if (!!result.value)
                    this.$http
                        .post("/v1/group", {
                            name: result.value,
                            group_id: this.group.id
                        })
                        .then(result => {
                            this.refresh();
                            Swal.fire({
                                icon: "success",
                                title: "Group Created",
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                scrollbarPadding: false
                            });
                        });
            });
        },
        removeGroup() {
            var options = {};
            $.map(this.group.subgroups, function(o) {
                options[o.id] = o.name;
            });

            Swal.fire({
                title: "Select Group to Delete",
                input: "select",
                inputOptions: options,
                showCancelButton: true,
                scrollbarPadding: false
            }).then(result => {
                if (!!result.value)
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Group and its subgroups will be gone forever!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: true,
                        allowOutsideClick: false,
                        scrollbarPadding: false
                    }).then(result2 => {
                        if (result2.value) {
                            this.$http
                                .delete("/v1/group/" + result.value)
                                .then(result => {
                                    this.refresh();
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Group has been deleted.",
                                        icon: "success",
                                        timer: 2000,
                                        timerProgressBar: true,
                                        scrollbarPadding: false
                                    });
                                })
                                .catch(err => {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        text: "Something, went wrong.",
                                        showConfirmButton: true,
                                        scrollbarPadding: false
                                    });
                                });
                        }
                    });
            });
        },
        refresh() {
            this.loading = true;
            this.$http
                .get("/v1/groups/all/total")
                .then(results => {
                    window.sessionStorage.setItem(
                        "leaderGroups",
                        JSON.stringify(results.data)
                    );
                    this.getGroup()
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error.response);
                });
        }
    }
};
</script>
<style>
.second .data:nth-child(2n) {
    background-color: rgba(0, 0, 0, 0.03);
}
</style>
