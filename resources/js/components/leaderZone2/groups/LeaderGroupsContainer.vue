<template>
    <div class="row justify-content-center">
        <div class="col-md-11 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="mt-auto mb-auto col-6">Groups :</div>
                        <div class="col-6 text-right">
                            <a class="ml-1" @click="createGroup()">
                                <span class="fa fa-plus"></span>
                            </a>
                            <a class="ml-1" @click="removeGroup()">
                                <span class="fa fa-minus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <leader-groups-component
                        v-for="(group) in groups"
                        :group="group"
                        :key="group.id+'group'"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Swal from "sweetalert2";
export default {
    props: ["groups"],
    data() {
        return {
            groups: this.groups
        };
    },
    methods: {
        createGroup() {
            Swal.fire({
                title: "Creating a new group.",
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
                            name: result.value
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
            $.map(this.groups, function(o) {
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
                        text: "Group will be gone forever!",
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
            this.$emit("refresh");
        }
    }
};
</script>

<style></style>
