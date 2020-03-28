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
                            <label for="course_id">Course</label>
                            <select
                                v-model="course_id"
                                name="course_id"
                                type="text"
                                class="form-control"
                            >
                                <option
                                    v-for="(course) in courses"
                                    :key="course.id"
                                    :value="course.id"
                                >{{course.name}}</option>
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
    props: ["courses"],
    date() {
        return {
            title: "",
            message: "",
            course_id: ""
        };
    },
    methods: {
        createNews() {
            this.$http
                .post("/v1/news", {
                    title: this.title,
                    message: this.message,
                    course_id: this.course_id
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
            this.course_id = "";
        }
    }
};
</script>

<style>
</style>
