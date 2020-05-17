<template>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8 col-sm-12 pb-3 pt-3">
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
                                <div class="col-8">Subgroups</div>
                                <div class="col-4 text-right">
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
                                    <a class="ml-1" @click="changeShowSubgroups()">
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
                        <div class="card-body" v-if="shouldShowSubgroups">
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
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">Courses</div>
                                <div class="col-4 text-right">
                                    <a class="ml-1" @click="createCourse()">
                                        <span class="fa fa-plus"></span>
                                    </a>
                                    <a
                                        @click="removeCourses()"
                                        v-if="this.group.courses.length!=0"
                                        class="ml-1"
                                    >
                                        <span class="fa fa-minus"></span>
                                    </a>
                                    <a class="ml-1" @click="changeShowCurses()">
                                        <span
                                            :class="{
                                        'fa fa-caret-down': !shouldShowCourses,
                                        'fa fa-caret-up': shouldShowCourses
                                    }"
                                        ></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="body" v-if="shouldShowCourses">
                            <div
                                class="card my-3 mx-4"
                                v-for="(course) in this.group.courses"
                                :key="'c'+course.id"
                            >
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-4">{{course.name}}</div>
                                        <div class="col-6">{{group.full_name}}</div>
                                        <div class="col-2 text-right">
                                            <a @click="removeCourse(course)" class="ml-1">
                                                <span class="fa fa-minus"></span>
                                            </a>
                                            <a @click="editName(course)" class="ml-1">
                                                <span class="fa fa fa-pen"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">Students Invitations</div>
                                <div class="col-4 text-right">
                                    <a class="ml-1" @click="inviteStudent()">
                                        <span class="fa fa-plus"></span>
                                    </a>
                                    <a
                                        @click="removeStudents()"
                                        v-if="this.group.group_invitation.length!=0"
                                        class="ml-1"
                                    >
                                        <span class="fa fa-minus"></span>
                                    </a>
                                    <a class="ml-1" @click="changeShowStudents()">
                                        <span
                                            :class="{
                                        'fa fa-caret-down': !shouldShowStudents,
                                        'fa fa-caret-up': shouldShowStudents
                                    }"
                                        ></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="body text-center" v-if="shouldShowStudents">
                            <div class="container second mb-3">
                                <div class="row mt-3">
                                    <div class="col">
                                        <b>
                                            <u>Invitations Sended</u>
                                            : {{this.group.group_invitation.length}}
                                        </b>
                                    </div>
                                    <div class="col">
                                        <b>
                                            <u>Invitations Accepted</u>
                                            : {{acceptedInvitations}}
                                        </b>
                                    </div>
                                </div>
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
                                        <a @click="removeStudent(invites)" class="ml-1">
                                            <span class="fa fa-minus"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            shouldShowCourses: true,
            shouldShowGroupData: true,
            shouldShowStudents: true
        };
    },
    mounted() {
        this.getGroup();
    },
    methods: {
        getGroup() {
            if (
                JSON.parse(window.sessionStorage.leaderGroups)[
                    this.$route.params.id
                ]
            )
                this.group = JSON.parse(window.sessionStorage.leaderGroups)[
                    this.$route.params.id
                ];
            else this.$router.push({ name: "LeaderZone" });
        },
        redirectToGroup(idGrupy) {
            this.$router.push({ name: "GroupView", params: { id: idGrupy } });
            this.getGroup();
        },
        changeShowSubgroups() {
            this.shouldShowSubgroups = !this.shouldShowSubgroups;
        },
        changeShowCurses() {
            this.shouldShowCourses = !this.shouldShowCourses;
        },
        changeShowGroupData() {
            this.shouldShowGroupData = !this.shouldShowGroupData;
        },
        changeShowStudents() {
            this.shouldShowStudents = !this.shouldShowStudents;
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
                showCancelButton: true
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
                                        showConfirmButton: true
                                    });
                                });
                        }
                    });
            });
        },
        createCourse() {
            Swal.fire({
                title: "Creating a new Course for " + this.group.name,
                text: "Course Name",
                input: "text",
                showCancelButton: true,
                confirmButtonText: "Create new Course",
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                scrollbarPadding: false
            }).then(result => {
                if (!!result.value)
                    this.$http
                        .post("/v1/course", {
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
        removeCourse(course) {
            Swal.fire({
                title: "Are you sure?",
                text: "Course will be gone forever!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
                scrollbarPadding: false
            }).then(result2 => {
                if (result2.value) {
                    this.$http
                        .delete("/v1/course/" + course.id)
                        .then(result => {
                            this.refresh();
                            Swal.fire({
                                title: "Deleted!",
                                text: "Course has been deleted.",
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
        },
        removeCourses() {
            var options = {};
            $.map(this.group.courses, function(o) {
                options[o.id] = o.name;
            });

            Swal.fire({
                title: "Select Course to Delete",
                input: "select",
                inputOptions: options,
                showCancelButton: true
            }).then(result => {
                if (!!result.value)
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Course will be gone forever!",
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
                                .delete("/v1/course/" + result.value)
                                .then(result => {
                                    this.refresh();
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Course has been deleted.",
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
        editName(course) {
            Swal.fire({
                title: "Change Course name from " + course.name,
                html:
                    '<label>New Name</label><input id="courseName" type="text" class="form-control mb-3"/>',
                showCancelButton: true,
                confirmButtonText: "Update Name!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
                allowOutsideClick: false,
                scrollbarPadding: false
            }).then(result => {
                if (!!result.value)
                    this.$http
                        .patch("/v1/course/" + course.id, {
                            name: document.getElementById("courseName").value
                        })
                        .then(results => {
                            this.refresh();
                            Swal.fire({
                                title: "Updated!",
                                text: "Name has been changed.",
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
            });
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
        removeStudents() {
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
                            "Student will no longer have access to this group and its upper groups!",
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
        removeStudent(invite) {
            Swal.fire({
                title: "Are you sure?",
                text: "Student will no longer have access to this group!",
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
                                showConfirmButton: true
                            });
                        });
                }
            });
        },
        refresh() {}
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
.second .data:nth-child(2n) {
    background-color: rgba(0, 0, 0, 0.03);
}
</style>
