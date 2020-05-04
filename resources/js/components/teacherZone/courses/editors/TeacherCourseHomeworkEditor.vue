<template>
    <!-- Modal -->
    <div
        class="modal fade text-center text-body"
        :id="'homeworkEditorModal'+homework.id"
        tabindex="-1"
        role="dialog"
        aria-labelledby="webHooksModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="webHooksModalLabel"
                    >Editing homework {{homework.name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name of homework</label>
                        <input v-model="name" name="name" type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            v-model="description"
                            name="description"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <label for="requirements">Requirements</label>
                        <textarea
                            v-model="requirements"
                            name="exams_webhook"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <label for="where_send">Where send homework</label>
                        <textarea
                            v-model="where_send"
                            name="where_send"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <datetime
                            v-model="deadline"
                            type="datetime"
                            input-class="form-control text-center"
                            :minute-step="5"
                        ></datetime>
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
                        @click="editHomework"
                        data-dismiss="modal"
                    >Apply</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import { Datetime } from "vue-datetime";
import "vue-datetime/dist/vue-datetime.css";
Vue.use(Datetime);
export default {
    props: ["homework"],
    data() {
        return {
            name: this.homework.name,
            description: this.homework.description,
            requirements: this.homework.requirements,
            where_send: this.homework.where_send,
            deadline: new Date(this.homework.deadline).toISOString()
        };
    },
    methods: {
        editHomework() {
            this.$http
                .patch("/v1/teacher/course/homework/"+this.homework.id, {
                    id: this.homework.id,
                    name: this.name,
                    description: this.description,
                    requirements: this.requirements,
                    where_send: this.where_send,
                    deadline: moment(this.deadline).format("YYYY:MM:DD HH:mm:ss"),
                    course_id: this.course_id
                })
                .then(result => {
                    this.clearModal();
                    this.$emit("refresh");
                })
                .catch(err => {});
        },
        clearModal() {
            this.name = this.homework.name;
            this.description = this.homework.description;
            this.requirements = this.homework.requirements;
            this.where_send = this.homework.where_send;
            this.deadline = new Date(this.homework.deadline).toISOString();
        }
    }
};
</script>
