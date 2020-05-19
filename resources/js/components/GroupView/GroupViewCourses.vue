<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-4 align-self-center">Courses</div>
                <div class="col-5 align-self-center text-center">
                    <b>
                        <u>Courses Total</u>
                        : {{this.group.courses.length}}
                    </b>
                </div>
                <div class="col-3 text-right align-self-center">
                    <a class="ml-1" @click="createCourse()">
                        <span class="fa fa-plus"></span>
                    </a>
                    <a @click="removeCourses()" v-if="this.group.courses.length!=0" class="ml-1">
                        <span class="fa fa-minus"></span>
                    </a>
                    <a class="ml-1" @click="changeShowCurses()" v-if="this.group.courses.length!=0">
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
        <div class="body" v-if="shouldShowCourses && this.group.courses.length!=0">
            <div class="card my-3 mx-4" v-for="(course) in this.group.courses" :key="'c'+course.id">
                <div class="card-header">
                    <div class="row">
                        <div class="col-3 align-self-center">{{course.name}}</div>
                        <div class="col-7 align-self-center text-center" v-if="!!course.teacher">
                            <b>
                                <u>Teacher</u>
                                : {{course.teacher.name}}
                            </b>
                        </div>
                        <div
                            class="col-7 align-self-center text-center"
                            v-if="!course.teacher && !course.course_invitation"
                        >
                            <b>There is no teacher assigned to this course yet.</b>
                        </div>
                        <div
                            class="col-7 align-self-center text-center"
                            v-if="!course.teacher && !!course.course_invitation"
                        >
                            <b>
                                Invitation to
                                <u>{{course.course_invitation.email}}</u> send but not accepted yet.
                            </b>
                        </div>
                        <div class="col-2 align-self-center text-right">
                            <a @click="removeCourse(course)" class="ml-1">
                                <span class="fa fa-minus"></span>
                            </a>
                            <a @click="editName(course)" class="ml-1">
                                <span class="fa fa-pen"></span>
                            </a>
                            <a
                                data-toggle="modal"
                                :data-target="'#courseInvitations'+course.id"
                                data-backdrop="static"
                                class="ml-1"
                            >
                                <span class="fa fa-user"></span>
                            </a>
                            <!-- Invitation modal -->
                            <div
                                class="modal fade text-center"
                                :id="'courseInvitations'+course.id"
                                tabindex="-1"
                                role="dialog"
                                aria-labelledby="courseInvitationsLabel"
                                aria-hidden="true"
                            >
                                <div class="modal-dialog" style="max-width:700px" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5
                                                class="modal-title"
                                                id="courseInvitationsLabel"
                                            >Course Invitations</h5>
                                            <button
                                                type="button"
                                                class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"
                                            >
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="col-12 py-1">
                                                    <h3>Teacher Invitation</h3>
                                                </div>
                                                <div class="col-12 py-1">
                                                    <div class="row">
                                                        <div class="col">E-mail</div>
                                                        <div
                                                            class="d-md-none d-sm-none d-none d-lg-block col"
                                                        >Invite date</div>
                                                        <div class="col">Joined date</div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <hr />
                                                </div>
                                                <div
                                                    class="col-12 py-1"
                                                    v-if="course.course_invitation"
                                                    :key="course.course_invitation.id"
                                                >
                                                    <div class="row text-center">
                                                        <div
                                                            class="col"
                                                        >{{course.course_invitation.email}}</div>
                                                        <div
                                                            class="d-md-none d-sm-none d-none d-lg-block col"
                                                        >{{course.course_invitation.created_at | formatDate}}</div>
                                                        <div
                                                            class="col"
                                                            v-if="course.course_invitation.accepted"
                                                        >{{course.course_invitation.updated_at | formatDate}}</div>
                                                        <div class="col" v-else>
                                                            <span
                                                                class="fas fa-times"
                                                                style="color:red"
                                                            ></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 py-2">
                                                    <div class="row">
                                                        <div class="col-6"></div>
                                                        <div class="col-6">
                                                            <button
                                                                type="button"
                                                                class="btn btn-primary"
                                                                v-if="course.course_invitation"
                                                                @click="removeTeacher(course.course_invitation)"
                                                                data-dismiss="modal"
                                                            >Remove Teacher</button>
                                                            <button
                                                                type="button"
                                                                class="btn btn-primary"
                                                                data-toggle="modal"
                                                                v-if="!course.course_invitation"
                                                                :data-target="'#courseinvite'+course.id"
                                                                data-dismiss="modal"
                                                            >Invite Teacher</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invite  Modal -->
                            <div
                                class="modal fade text-center"
                                :id="'courseinvite'+course.id"
                                :ref="'courseinvite'+course.id"
                                tabindex="-1"
                                role="dialog"
                                aria-labelledby="groupInviteLabel"
                                aria-hidden="true"
                            >
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5
                                                class="modal-title"
                                                id="groupInviteLabel"
                                            >Course Invitation</h5>
                                            <button
                                                type="button"
                                                class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"
                                            >
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
                                                @click="courseInvite(course.id)"
                                                data-dismiss="modal"
                                            >Invite</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            shouldShowCourses: true
        };
    },
    methods: {
        changeShowCurses() {
            this.shouldShowCourses = !this.shouldShowCourses;
        },
        clearInviteModal() {
            this.invitationEmail = "";
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
                                title: "Course Created",
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
                                showConfirmButton: true,
                                scrollbarPadding: false
                            });
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
                                showConfirmButton: true,
                                scrollbarPadding: false
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
                                showConfirmButton: true,
                                scrollbarPadding: false
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
                showCancelButton: true,
                scrollbarPadding: false
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
                                        showConfirmButton: true,
                                        scrollbarPadding: false
                                    });
                                });
                        }
                    });
            });
        },
        courseInvite(id) {
            this.$http
                .post("/v1/courses/" + id + "/invite", {
                    email: this.invitationEmail
                })
                .then(results => {
                    this.refresh();
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
                            text: "E-mail wasn't valid",
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            scrollbarPadding:false,
                        });
                    // this.error = error.response.data.errors;
                });
        },
        removeTeacher(course_invitation){

            Swal.fire({
                        title: "Are you sure?",
                        text: "Invitation will be deleted. Teacher will no longer have access to this group!",
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
                                .delete("/v1/course/"+course_invitation.id+"/invite")
                                .then(result => {
                                    this.refresh();
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Invitation has been deleted.",
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
    }
};
</script>

<style>
</style>
