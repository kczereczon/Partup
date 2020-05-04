<template>
    <div style="display:inline;">
        <a
            data-toggle="modal"
            :data-target="'#homeworkModal'+course.id"
            class="ml-1 bg-primary text-white px-2 py-1 rounded-circle"
        >
            <span class="fa fa-plus"></span>
        </a>
        <!-- Modal -->
        <div
            class="modal fade text-center"
            :id="'homeworkModal'+course.id"
            tabindex="-1"
            role="dialog"
            aria-labelledby="webHooksModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="webHooksModalLabel">Setting up Homework for {{course.name}}</h5>
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
                            <datetime v-model="deadline" type="datetime" input-class="form-control text-center" :minute-step="5"></datetime>
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
                            @click="createHomework"
                            data-dismiss="modal"
                        >Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
Vue.use(Datetime);
export default {
    props: ["course"],
    date() {
        return {
            deadline: "",
            name: "",
            description: "",
            requirements: "",
            where_send: "",
        };
    },
    methods: {
        createHomework() {
            this.$http
                .post("/v1/homeworks", {
                    deadline: moment(this.deadline).format('YYYY:MM:DD HH:mm:ss'),
                    name: this.name,
                    description: this.description,
                    requirements: this.requirements,
                    where_send: this.where_send,
                    course_id: this.course.id
                })
                .then(result => {
                    this.refresh();
                    this.clearModal();
                })
                .catch(err => {});
        },
        clearModal() {
            this.deadline = "";
            this.name = "";
            this.description = "";
            this.requirements = "";
            this.where_send = "";
        },
        refresh() {
            this.$emit("refresh");
        }
    }
}
</script>
