<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-4 align-self-center">Students Invitations</div>
                <div class="col-5">
                    <div class="row">
                        <div class="col text-center">
                            <b>
                                <u>Invitations Sended</u>
                                : {{this.group.group_invitation.length}}
                            </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <b>
                                <u>Invitations Accepted</u>
                                : {{acceptedInvitations}}
                            </b>
                        </div>
                    </div>
                </div>
                <div class="col-3 text-right align-self-center">
                    <a class="ml-1" @click="inviteStudent()">
                        <span class="fa fa-plus"></span>
                    </a>
                    <a
                        @click="removeStudentsInvite()"
                        v-if="this.group.group_invitation.length!=0"
                        class="ml-1"
                    >
                        <span class="fa fa-minus"></span>
                    </a>
                    <a
                        class="ml-1"
                        @click="changeShowStudentsInvites()"
                        v-if="this.group.group_invitation.length!=0"
                    >
                        <span
                            :class="{
                                        'fa fa-caret-down': !shouldShowStudentsInvites,
                                        'fa fa-caret-up': shouldShowStudentsInvites
                                    }"
                        ></span>
                    </a>
                </div>
            </div>
        </div>
        <div
            class="body text-center"
            v-if="shouldShowStudentsInvites && this.group.group_invitation.length!=0"
        >
            <div class="container second mb-3">
                <div class="row mt-3"></div>
                <div class="row mt-3 mx-1">
                    <div class="col-6 col-sm-4 text-center">
                        <b>E-mail</b>
                    </div>
                    <div class="d-none px d-sm-block col-sm-3 text-center">
                        <b>Invited date</b>
                    </div>
                    <div class="col-6 col-sm-3 text-center">
                        <b>Joined date</b>
                    </div>
                    <div class="d-none d-sm-block col-sm-2 text-center">
                        <b>Remove</b>
                    </div>
                </div>
                <hr />
                <div
                    class="row data mx-1"
                    v-for="(invites) in this.group.group_invitation"
                    :key="'i'+invites.id"
                >
                    <div class="col-6 col-sm-4 text-center">{{invites.email}}</div>
                    <div
                        class="d-none d-sm-block col-sm-3 text-center"
                    >{{invites.created_at | formatDate}}</div>
                    <div
                        class="col-6 col-sm-3 text-center"
                        v-if="invites.accepted==1"
                    >{{invites.updated_at | formatDate}}</div>
                    <div class="col-6 px-0 col-sm-3 text-center" v-else>
                        <span class="fas fa-times" style="color:red"></span>
                    </div>
                    <div class="d-none d-sm-block col-sm-2 text-center">
                        <a @click="removeStudentInvite(invites)" class="ml-1">
                            <span class="fa fa-minus"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
export default {
    props: ["group"],
    data() {
        return {
            shouldShowStudentsInvites: true
        };
    },
    methods: {
        changeShowStudentsInvites() {
            this.shouldShowStudentsInvites = !this.shouldShowStudentsInvites;
        },
        inviteStudent() {
            Swal.fire({
                title: "Group Invitation for " + this.group.name,
                text: "E-mail of student",
                input: "text",
                showCancelButton: true,
                confirmButtonText: "Invite Student",
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                scrollbarPadding: false
            }).then(result => {
                if (!!result.value)
                    this.$http
                        .post("/v1/groups/" + this.group.id + "/invite", {
                            email: result.value
                        })
                        .then(result => {
                            this.refresh();
                            Swal.fire({
                                icon: "success",
                                title: "Student Invited",
                                showConfirmButton: false,
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
                                showConfirmButton: true
                            });
                        });
            });
        },
        removeStudentsInvite() {
            var options = {};
            $.map(this.group.group_invitation, function(o) {
                options[o.id] = o.email;
            });

            Swal.fire({
                title: "Select Student Invitation E-mail to Remove",
                input: "select",
                inputOptions: options,
                showCancelButton: true
            }).then(result => {
                if (!!result.value)
                    Swal.fire({
                        title: "Are you sure?",
                        text:
                            "Student invitations will be removed and, student will no longer have access to this group and its upper groups!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, remove him!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: true,
                        allowOutsideClick: false,
                        scrollbarPadding: false
                    }).then(result2 => {
                        if (result2.value) {
                            this.$http
                                .delete("/v1/group/" + result.value + "/invite")
                                .then(result => {
                                    this.refresh();
                                    Swal.fire({
                                        title: "Removed!",
                                        text: "Student removed.",
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
                                        showConfirmButton: true
                                    });
                                });
                        }
                    });
            });
        },
        removeStudentInvite(invite) {
            Swal.fire({
                title: "Are you sure?",
                text:
                    "Student invitations will be removed and, student will no longer have access to this group and its upper groups!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, remove him!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
                allowOutsideClick: false,
                scrollbarPadding: false
            }).then(result2 => {
                if (result2.value) {
                    this.$http
                        .delete("/v1/group/" + invite.id + "/invite")
                        .then(result => {
                            this.refresh();
                            Swal.fire({
                                title: "Removed!",
                                text: "Student removed.",
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
        },
        refresh() {
            this.$emit("refresh");
        }
    },
    computed: {
        acceptedInvitations: function() {
            let amount = 0;
            for (let i = 0; i < this.group.group_invitation.length; i++) {
                if (this.group.group_invitation[i].accepted != null) amount++;
            }
            return amount;
        }
    }
};
</script>

<style>
</style>
