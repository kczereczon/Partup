<template>
<div>
        <button class="btn btn-primary mx-1 my-3" data-toggle="modal" data-target="#newsModal">
            <span class="fa fa-gear"></span> ADD NEWS
        </button>
        <!-- Modal -->
        <div
            class="modal fade"
            id="newsModal"
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
                            <label for="title">Name of News</label>
                            <input v-model="title" name="title" type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="group_id">Group</label>
                            <select
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Group name."
                                v-model="group_id"
                            >
                                <option
                                    v-for="group in groups"
                                    :key="group.id"
                                    :value="group.id"
                                    :selected="group.id == group.id"
                                    >{{ group.full_name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Description</label>
                            <textarea
                                v-model="message"
                                name="message"
                                type="text"
                                class="form-control"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            @click="clearModal"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >Close</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="createNews"
                            data-dismiss="modal"
                        >Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["groups"],
    date() {
        return {
            title: "",
            message: "",
            group_id: ""
        };
    },
    methods: {
        createNews() {
            this.$http
                .post("/v1/news", {
                    title: this.title,
                    message: this.message,
                    group_id: this.group_id
                })
                .then(result => {
                    this.refreshCourses();
                    this.clearModal();
                })
                .catch(err => {});
        },
        clearModal() {
            this.title = "";
            this.message = "";
            this.group_id = "";
        }
    }
};
</script>

<style>
</style>
