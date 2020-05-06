<template>
    <div class="card">
        <div class="card-body bg-light">
            <div class="row no-gutters">
                <div class="col-6 mt-auto mb-auto">
                    <h5 v-if="!editMode" class="mb-0">{{ name }}</h5>
                    <div class="input-group">
                        <input
                            v-model="newName"
                            v-if="editMode"
                            placeholder="Group item."
                            class="form-control"
                            ref="input"
                            type="text"
                        />
                        <div v-if="error" class="invalid-feedback">
                            <p
                                class="mb-2"
                                v-for="(message, index) in error"
                                :key="index"
                            >{{ message }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 mt-auto mb-auto text-right">
                    <div class="row">
                        <div class="col">
                            <a
                                v-if="editMode"
                                class="ml-1"
                                data-toggle="modal"
                                :data-target="
                                    '#webHooksModal-0' + parent_id + '-0' + id
                                "
                            >
                                <span class="fa fa-gear"></span>
                            </a>
                            <a
                                v-if="
                                    !editMode && subgroups && subgroups.length
                                "
                                v-on:click="
                                    shouldShowSubgroups = !shouldShowSubgroups
                                "
                                class="ml-1"
                            >
                                <span
                                    :class="{
                                        'fa fa-caret-down': !shouldShowSubgroups,
                                        'fa fa-caret-up': shouldShowSubgroups
                                    }"
                                ></span>
                            </a>
                            <a v-on:click="addGroup" v-if="!editMode" class="ml-1">
                                <span class="fa fa-plus"></span>
                            </a>
                            <a v-on:click="removeGroup" v-if="!editMode" class="ml-1">
                                <span class="fa fa-minus"></span>
                            </a>
                            <a
                                v-on:click="id ? close() : removeGroup()"
                                v-if="editMode"
                                class="ml-1"
                            >
                                <span class="fa fa-times"></span>
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
                                :data-target="'#groupInvitations'+id"
                                data-backdrop="static"
                                class="ml-1"
                            >
                                <span class="fa fa-users"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invite list Modal -->
        <div
            class="modal fade text-center"
            :id="'groupInvitations'+id"
            :ref="'groupInvitations'+id"
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
                            <div
                                class="col-12 py-1"
                                v-for="invite in invites"
                                :key="invite.id"
                            >
                                <div class="row text-center">
                                    <div class="col-8 col-lg-4">{{invite.email}}</div>
                                    <div
                                        class="d-md-none d-sm-none d-none d-lg-block col-sm-3"
                                    >{{invite.created_at}}</div>
                                    <div class="col-4 col-lg-2" v-if="invite.accepted">
                                        <span class="fa fa-check" style="color:green"></span>
                                    </div>
                                    <div class="col-4 col-lg-2" v-else>
                                        <span class="fa fa-times" style="color:red"></span>
                                    </div>
                                    <div
                                        class="d-md-none d-sm-none d-none d-lg-block col-lg-3"
                                        v-if="invite.accepted"
                                    >{{invite.updated_at}}</div>
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
                                    :data-target="'#invite'+id"
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
            :id="'invite'+id"
            :ref="'invite'+id"
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
                            <div v-if="error.email" class="alert alert-danger"><p
                                class="mb-2"
                                v-for="(message, index) in error.email"
                                :key="index"
                            >{{ message }}</p></div>
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
                        >Invite</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Webhooks Modal -->
        <div
            class="modal fade"
            :id="'webHooksModal-0' + parent_id + '-0' + id"
            tabindex="-1"
            role="dialog"
            aria-labelledby="webHooksModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="webHooksModalLabel">Setting for the group.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="homework_webhook">Homework Webhook</label>
                            <input
                                v-model="homework_webhook"
                                name="homework_webhook"
                                type="text"
                                class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label for="news_webhook">News Webhook</label>
                            <input
                                v-model="news_webhook"
                                name="news_webhook"
                                type="text"
                                class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label for="exams_webhook">Exam Webhook</label>
                            <input
                                v-model="exams_webhook"
                                name="exams_webhook"
                                type="text"
                                class="form-control"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            @click="clearWebhookModal"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Apply</button>
                    </div>
                </div>
            </div>
        </div>

        <ul v-if="shouldShowSubgroups" class="list-group list-group-flush">
            <li
                v-for="(group, index) in subgroups"
                :key="group.id"
                :class="[{ 'border-top': index == 0 }, 'list-group-item']"
            >
                <group-component
                    v-on:remove="subgroups.splice(index, 1)"
                    v-on:refresh="refresh"
                    :id="group.id"
                    :name="group.name"
                    :subgroups="group.subgroups"
                    :editMode="group.id ? false : true"
                    :parent_id="id"
                    :homework_webhook="group.homework_webhook"
                    :exams_webhook="group.exams_webhook"
                    :news_webhook="group.news_webhook"
                    :group="group"
                />
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ["id", "name", "parent_id"],
    data() {
        return {
            shouldShowSubgroups: false,
            editMode:
                this.$attrs.editMode != undefined
                    ? this.$attrs.editMode
                    : false,
            subgroups: this.$attrs.subgroups ? this.$attrs.subgroups : [],
            homework_webhook: this.$attrs.homework_webhook
                ? this.$attrs.homework_webhook
                : "",
            news_webhook: this.$attrs.news_webhook
                ? this.$attrs.news_webhook
                : "",
            exams_webhook: this.$attrs.exams_webhook
                ? this.$attrs.exams_webhook
                : "",
            invites: this.$attrs.invites,
            error: [],
            newName: this.name,
            invitationEmail: ""
        };
    },
    created() {
        if (this.$attrs.editMode || !this.id)
            this.editMode = this.$attrs.editMode;
    },
    methods: {
        edit() {
            this.editMode = true;
        },
        save() {
            this.name = this.newName;

            if (!this.id) {
                this.$http
                    .post("/v1/groups", {
                        name: this.name,
                        homework_webhook: this.homework_webhook,
                        news_webhook: this.news_webhook,
                        exams_webhook: this.exams_webhook,
                        group_id: this.parent_id
                    })
                    .then(results => {
                        this.refresh();
                        this.close();
                    })
                    .catch(error => {
                        this.error = error.response.data.errors;
                    });
            } else {
                this.$http
                    .patch("/v1/groups/" + this.id, {
                        name: this.name,
                        homework_webhook: this.homework_webhook,
                        news_webhook: this.news_webhook,
                        exams_webhook: this.exams_webhook,
                        group_id: this.parent_id
                    })
                    .then(results => {
                        this.$emit("refresh");
                        this.close();
                    })
                    .catch(error => {
                        this.error = error.response.data.errors;
                    });
            }
        },
        close() {
            this.editMode = false;
        },
        showSubgroups() {
            this.shouldShowSubgroups = true;
        },
        removeGroup() {
            if (confirm("Remove selected group?")) this.$emit("remove");
        },
        addGroup() {
            this.showSubgroups();
            if (this.subgroups[0] == undefined || this.subgroups[0].id) {
                this.subgroups.unshift({});
            }
        },
        clearWebhookModal() {
            this.homework_webhook = this.$attrs.homework_webhook;
            this.news_webhook = this.$attrs.news_webhook;
            this.exams_webhook = this.$attrs.exams_webhook;
        },
        clearInviteModal() {
            this.invitationEmail = "";
        },
        groupInvite() {
            this.$http
                .post("/v1/groups/"+this.id+"/invite", {
                    email: this.invitationEmail
                })
                .then(results => {
                    this.refresh();
                    this.clearInviteModal();
                    this.$refs['invite'+this.id].modal('hide');
                })
                .catch(error => {
                    this.error = error.response.data.errors;
                });
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
                        this.subgroups.splice(index, 1);
                        this.getGroups();
                    })
                    .catch(error => console.log(error.response));
            } else {
                this.groups.splice(index, 1);
            }
        },
        refresh() {
            this.$emit("refresh");
        }
    }
};
</script>

<style lang="sass"></style>
