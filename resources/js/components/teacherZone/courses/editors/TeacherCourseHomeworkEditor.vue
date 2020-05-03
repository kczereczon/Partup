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
                        <h5 class="modal-title" id="webHooksModalLabel">Editing homework {{homework.name}}</h5>
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
</template>
<script>
import moment from 'moment'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
Vue.use(Datetime);
export default {
    props: ["homework"],
    date() {
        return {
            deadline: this.homework.deadline,
            name: this.homework.name,
            description: this.homework.description,
            requirements: this.homework.requirements,
            where_send: this.homework.where_send,
        };
    },
    methods: {
        createExam() {
            this.$http
                .post("/v1/exam", {
                    name: this.name,
                    range_of_knowlage: this.range_of_knowlage,
                    description: this.description,
                    place: this.place,
                    time: moment(this.time).format('YYYY:MM:DD HH:mm:ss'),
                    course_id: this.course.id
                })
                .then(result => {
                    // this.refreshCourses();
                    this.clearModal();
                })
                .catch(err => {});
        },
        clearModal() {
            this.deadline = this.homework.deadline;
            this.name = this.homework.name;
            this.description = this.homework.description;
            this.requirements = this.homework.requirements;
            this.where_send = this.homework.where_send;
        }
    }
}
</script>
