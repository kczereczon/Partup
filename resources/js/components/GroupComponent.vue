<template>
    <div class="card">
        <div class="card-body bg-light">
            <div class="row no-gutters">
                <div class="col-6 mt-auto mb-auto">
                    <h5 v-if="!editMode" class="mb-0">{{name}}</h5>
                    <input
                        v-model="name"
                        v-if="editMode"
                        class="form-control"
                        ref="input"
                        type="text"
                    />
                </div>
                <div class="col-6 mt-auto mb-auto text-right">
                    <div class="row">
                        <div class="col">
                            <a class="ml-1" data-toggle="modal" data-target="#webHooksModal">
                                <span class="fa fa-gear"></span>
                            </a>
                            <a
                                v-if="!editMode && subgroups && subgroups.length"
                                v-on:click="shouldShowSubgroups = !shouldShowSubgroups"
                                class="ml-1"
                            >
                                <span
                                    :class="{'fa fa-caret-down': !shouldShowSubgroups, 'fa fa-caret-up': shouldShowSubgroups}"
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
                                <span :class="{'fa fa-pen': !editMode, 'fa fa-save': editMode}"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="webHooksModal"
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
                            <label for="exam_webhook">Exam Webhook</label>
                            <input
                                v-model="exam_webhook"
                                name="exam_webhook"
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
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <ul v-if="shouldShowSubgroups" class="list-group list-group-flush">
            <li
                v-for="(group, index) in subgroups"
                :key="group.id"
                :class="[{'border-top': index == 0}, 'list-group-item']"
            >
                <group-component
                    v-on:remove="subgroups.splice(index, 1)"
                    :id="group.id"
                    :name="group.name"
                    :subgroups="group.subgroups"
                />
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ["id", "name"],
    data() {
        return {
            shouldShowSubgroups: false,
            editMode: false,
            subgroups: this.$attrs.subgroups ? this.$attrs.subgroups : [],
            homework_webhook: this.$attrs.homework_webhook
                ? this.$attrs.homework_webhook
                : "",
            news_webhook: this.$attrs.news_webhook
                ? this.$attrs.news_webhook
                : "",
            exam_webhook: this.$attrs.exam_webhook
                ? this.$attrs.exam_webhook
                : ""
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
            this.close();
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
            this.subgroups.unshift({ name: "New subgroup." });
        },
        clearWebhookModal() {
            this.homework_webhook = this.$attrs.homework_webhook;
            this.news_webhook = this.$attrs.news_webhook;
            this.exam_webhook = this.$attrs.exam_webhook;
        }
    }
};
</script>

<style lang="sass">
</style>
