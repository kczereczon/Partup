<template>
    <div>
        <div class="card">
            <div class="card-body bg-light">
                <div class="row no-gutters">
                    <div class="col-4 mt-auto mb-auto">
                        <h5 class="mb-0" v-if="!editMode">{{ name || "" }}</h5>
                        <input
                            v-if="editMode"
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Course name."
                            v-model="newName"
                        />
                    </div>
                    <div class="col-6 mt-auto mb-auto">
                        <h5 class="mb-0" v-if="!editMode">{{ group.full_name || "" }}</h5>
                        <select
                            v-if="editMode"
                            type="text"
                            name="name"
                            class="form-control ml-auto mr-auto w-75"
                            placeholder="Course name."
                            v-model="newGroupId"
                        >
                            <option
                                v-for="optionGroup in groups"
                                :key="optionGroup.id"
                                :value="optionGroup.id"
                                :selected="optionGroup.id == group.id"
                            >{{ optionGroup.full_name }}</option>
                        </select>
                    </div>
                    <div class="col-2 mt-auto mb-auto text-right">
                        <a v-if="editMode" class="ml-1">
                            <span class="fa fa-user-add"></span>
                        </a>
                        <a v-on:click="close()" class="ml-1">
                            <span
                                :class="[
                                'fa',
                                { 'fa-minus': !editMode, 'fa-times': editMode }
                            ]"
                            ></span>
                        </a>
                        <a v-on:click="editMode ? save() : edit()" class="ml-1">
                            <span
                                :class="{
                                'fa fa-pen': !editMode,
                                'fa fa-save': editMode
                            }"
                            ></span>
                        </a>
                        <a
                            data-toggle="modal"
                            :data-target="'#courseInvitations'+id"
                            data-backdrop="static"
                            class="ml-1"
                        >
                            <i class="fa fa-user"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Invite list Modal -->
        <div
            class="modal fade text-center"
            :id="'courseInvitations'+id"
            tabindex="-1"
            role="dialog"
            aria-labelledby="courseInvitationsLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" style="max-width:750px" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="courseInvitationsLabel">Course Invitations</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="col-12 py-1">
                                <h3>Teacher</h3>
                            </div>
                            <div class="col-12 py-1">
                                <div class="row">
                                    <div class="col-8 col-lg-4">E-mail</div>
                                    <div
                                        class="d-md-none d-sm-none d-none d-lg-block col-lg-3"
                                    >Invite date</div>
                                    <div class="col-4 col-lg-2" style="overflow:visible">Joined</div>
                                    <div
                                        class="d-md-none d-sm-none d-none d-lg-block col-lg-3"
                                    >Joined date</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr />
                            </div>
                            <div class="col-12 py-1" v-if="invite" :key="invite.id">
                                <div class="row text-center">
                                    <div class="col-8 col-lg-4">{{invite.email}}</div>
                                    <div
                                        class="d-md-none d-sm-none d-none d-lg-block col-sm-3"
                                    >{{invite.created_at | formatDate}}</div>
                                    <div class="col-4 col-lg-2" v-if="invite.accepted">
                                        <span class="fa fa-check" style="color:green"></span>
                                    </div>
                                    <div class="col-4 col-lg-2" v-else>
                                        <span class="fa fa-times" style="color:red"></span>
                                    </div>
                                    <div
                                        class="d-md-none d-sm-none d-none d-lg-block col-lg-3"
                                        v-if="invite.accepted"
                                    >{{invite.updated_at | formatDate}}</div>
                                    <div
                                        class="d-md-none d-sm-none d-none d-lg-block col-lg-3"
                                        v-else
                                    >
                                        <i class="fas fa-times" style="color:red"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 py-2">
                                <button
                                    type="button"
                                    class="btn btn-primary w-50"
                                    data-toggle="modal"
                                    :data-target="'#courseinvite'+id"
                                    data-dismiss="modal"
                                >Invite Teacher</button>
                                <button
                                    type="button"
                                    class="btn btn-primary w-50"
                                    @click="removeTeacher"
                                    data-dismiss="modal"
                                >Remove Teacher</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invite  Modal -->
        <div
            class="modal fade text-center"
            :id="'courseinvite'+id"
            :ref="'courseinvite'+id"
            tabindex="-1"
            role="dialog"
            aria-labelledby="groupInviteLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="groupInviteLabel">Course Invitation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">E-mail of Teacher</label>
                            <input
                                v-model="invitationEmail"
                                name="title"
                                type="text"
                                class="form-control"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            @click="clearInviteModal"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >Close</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="courseInvite"
                            data-dismiss="modal"
                        >Invite</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
export default {
    props: ["id", "name", "groups", "group", "new"],
    created() {
        console.log(this.new);
    },
    methods: {
        save() {
            if (!this.id) {
                this.$http
                    .post("/v1/course", {
                        name: this.newName,
                        group_id: this.newGroupId
                    })
                    .then(result => {
                        this.editMode = false;
                        this.refreshCourses();
                    })
                    .catch(err => {});
            } else {
                this.$http
                    .patch("/v1/course/" + this.id, {
                        name: this.newName,
                        group_id: this.newGroupId
                    })
                    .then(result => {
                        this.editMode = false;
                        this.refreshCourses();
                    })
                    .catch(error => {
                        this.error = error.response.data.errors;
                    });
            }
        },
        close() {
            if (!this.editMode) {
                if (confirm("Are you sure, you want remove this course?"))
                    this.$http
                        .delete("/v1/course/" + this.id)
                        .then(result => {
                            this.removeCourseFromArray();
                            this.refreshCourses();
                        })
                        .catch(err => {});
            } else {
                if (this.id) {
                    this.editMode = false;
                } else {
                    this.removeCourseFromArray();
                }
            }
        },
        courseInvite() {
            this.$http
                .post("/v1/courses/" + this.id + "/invite", {
                    email: this.invitationEmail
                })
                .then(results => {
                    this.refreshCourses();
                    this.clearInviteModal();
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Invitation send",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        scrollbarPadding:false,
                    });
                })
                .catch(error => {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Error Occured",
                            text: error.response.data.error,
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            scrollbarPadding:false,
                        });
                    // this.error = error.response.data.errors;
                });
        },
        clearInviteModal() {
            this.invitationEmail = "";
        },
        edit() {
            this.editMode = true;
        },
        refreshCourses() {
            this.$emit("refresh");
        },
        removeCourseFromArray() {
            this.$emit("removeCourseFromArray", this.id);
        },
        removeTeacher() {
            this.refreshCourses();
            this.$http
                .post("/v1/groups", {
                    email: this.invitationEmail
                })
                .then(results => {
                    this.refreshCourses();
                    this.clearInviteModal();
                })
                .catch(error => {
                    this.error = error.response.data.errors;
                });
        }
    },
    data() {
        return {
            editMode: this.new,
            newName: this.name,
            newGroupId: this.group.id || "",
            invite: this.$attrs.invites
        };
    }
};
</script>

<style></style>
