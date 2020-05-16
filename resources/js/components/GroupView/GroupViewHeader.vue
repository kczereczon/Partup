<template>
    <div class="row">
        <div class="col-8">
            <nav aria-label="breadcrumb" class="h-100">
                <ol class="breadcrumb h-100 my-0 px-0 py-0" style="background:none;">
                    <li
                        v-for="parent in flat"
                        :key="parent.id"
                        :class="['breadcrumb-item', {'active': parent.active}]"
                    >
                        <a
                            v-if="!parent.active"
                            @click="redirectToGroup(parent.id, $event)"
                            href="#"
                            class="px-2 py-2"
                            style="font-size: 1.125rem;"
                        >{{parent.name}}</a>
                        <span
                            v-if="parent.active"
                            style="font-size: 1.125rem;"
                            class="px-2 py-2 text-dark"
                        >{{parent.name}}</span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-4 text-right">
            <a @click="editName()" class="ml-1" v-if="shouldShowGroupData">
                <span class="fa fa fa-pen"></span>
            </a>
            <a class="ml-1" @click="editWebHooks()" v-if="shouldShowGroupData">
                <span class="fa fa-gear"></span>
            </a>
            <a
                data-toggle="modal"
                :data-target="'#groupInvitations'+group.id"
                data-backdrop="static"
                class="ml-1"
                v-if="shouldShowGroupData"
            >
                <span class="fa fa-users"></span>
            </a>
            <a class="ml-1" @click="changeShowGroupData()">
                <span
                    :class="{
                    'fa fa-caret-down': !shouldShowGroupData,
                    'fa fa-caret-up': shouldShowGroupData
                }"
                ></span>
            </a>
        </div>
        <!-- Invite list Modal -->
        <div
            class="modal fade text-center"
            :id="'groupInvitations'+group.id"
            tabindex="-1"
            role="dialog"
            aria-labelledby="groupInvitationsLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" style="max-width:750px" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="groupInvitationsLabel">Group Invitations</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="col-12 py-1">
                                <h3>Students</h3>
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
                            <div class="col-12 py-1" v-for="invite in invites" :key="invite.id">
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
                                    :data-target="'#groupinvite'+group.id"
                                    data-dismiss="modal"
                                >Invite Student</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Invite  Modal -->
        <div
            class="modal fade text-center"
            :id="'groupinvite'+group.id"
            :ref="'groupinvite'+group.id"
            tabindex="-1"
            role="dialog"
            aria-labelledby="groupInviteLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="groupInviteLabel">Group Invitations</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">E-mail of Student</label>
                            <!-- <div v-if="error.email" class="alert alert-danger"><p
                                class="mb-2"
                                v-for="(message, index) in error.email"
                                :key="index"
                            >{{ message }}</p></div>-->
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
                            @click="groupInvite"
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
    props: ["group", "shouldShowGroupData"],
    data() {
        return {
            flat: [],
            name: "",
            error: [],
            invitationEmail: ""
        };
    },
    created() {
        this.group.active = true;
        this.flatten(this.$props.group);
        this.flat.reverse();
    },
    methods: {
        redirectToGroup(idGrupy, event) {
            event.preventDefault();
            this.$router.push({ name: "GroupView", params: { id: idGrupy } });
            this.$emit("refresh");
        },
        flatten(el) {
            this.flat.push(el);
            if (el.group) {
                this.flatten(el.group);
            }
        },
        changeShowGroupData() {
            this.$emit("changeShowGroupData");
        },
        editWebHooks() {
            var homework_webhook = "";
            var news_webhook = "";
            var exams_webhook = "";
            if (!!this.group.homework_webhook)
                homework_webhook = this.group.homework_webhook;
            if (!!this.group.news_webhook)
                news_webhook = this.group.news_webhook;
            if (!!this.group.exams_webhook)
                exams_webhook = this.group.exams_webhook;
            Swal.fire({
                title: "Web hook editor for " + this.group.name,
                html:
                    '<label class="mt-3">Homework Webhook</label><input id="homework_webhook" value="' +
                    homework_webhook +
                    '" type="text" class="form-control mb-3"/>' +
                    '<label>News Webhook</label><input id="news_webhook" value="' +
                    news_webhook +
                    '" type="text" class="form-control mb-3"/>' +
                    '<label>Exam Webhook</label><input id="exams_webhook" value="' +
                    exams_webhook +
                    '" type="text" class="form-control mb-3"/>',
                showCancelButton: true,
                confirmButtonText: "Update Webhooks!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
                allowOutsideClick: false,
                scrollbarPadding: false
            }).then(result => {
                if (!!result.value)
                    this.$http
                        .patch("/v1/group/" + this.group.id, {
                            name: this.group.name,
                            homework_webhook: document.getElementById(
                                "homework_webhook"
                            ).value,
                            news_webhook: document.getElementById(
                                "news_webhook"
                            ).value,
                            exams_webhook: document.getElementById(
                                "exams_webhook"
                            ).value
                        })
                        .then(results => {
                            this.refresh();
                            Swal.fire({
                                title: "Updated!",
                                text: "Webhooks has been updated.",
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
        editName() {
            Swal.fire({
                title: "Change Group name from " + this.group.name,
                html:
                    '<label>New Name</label><input id="groupName" type="text" class="form-control mb-3"/>',
                showCancelButton: true,
                confirmButtonText: "Update Name!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
                allowOutsideClick: false,
                scrollbarPadding: false
            }).then(result => {
                if (!!result.value)
                    this.$http
                        .patch("/v1/group/" + this.group.id, {
                            name: document.getElementById("groupName").value
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
        groupInvite() {
            this.$http
                .post("/v1/groups/" + this.group.id + "/invite", {
                    email: this.invitationEmail
                })
                .then(results => {
                    this.refresh();
                    this.clearInviteModal();
                    Swal.fire({
                        icon: "success",
                        title: "Invitation send",
                        showConfirmButton: true,
                        timer: 2000,
                        timerProgressBar: true,
                        scrollbarPadding: false
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Something, went wrong.",
                        showConfirmButton: true
                    });
                });
        },
        clearInviteModal() {
            this.invitationEmail = "";
        },
        refresh() {
            //refresh data in memory
        }
    }
};
</script>
<style></style>
