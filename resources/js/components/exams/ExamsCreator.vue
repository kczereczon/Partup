<template>
    <div>
        <button class="btn btn-primary w-100 my-3" data-toggle="modal" data-target="#ExamsModal">
            <span class="fa fa-gear"></span> ADD EXAM
        </button>
        <!-- Modal -->
        <div
            class="modal fade"
            id="ExamsModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="webHooksModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="webHooksModalLabel">Setting for the course.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input v-model="name" name="name" type="text" class="form-control" />
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
                            <label for="range_of_knowlage">Range of knowlage</label>
                            <textarea
                                v-model="range_of_knowlage"
                                name="range_of_knowlage"
                                type="text"
                                class="form-control"
                            />
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
                            <label for="place">Place</label>
                            <textarea
                                v-model="place"
                                name="place"
                                type="text"
                                class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <datetime v-model="time" type="datetime" input-class="form-control" minute-step="5"></datetime>
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
                            @click="createExam"
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
    props: ["courses"],
    date() {
        return {
            name: "",
            range_of_knowlage: "",
            description: "",
            place: "",
            time: "",
            course_id: ""
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
                    course_id: this.course_id
                })
                .then(result => {
                    this.refreshCourses();
                    this.clearModal();
                })
                .catch(err => {});
        },
        clearModal() {
            this.name = "";
            this.range_of_knowlage = "";
            this.description = "";
            this.place = "";
            this.time = "";
            this.course_id = "";
        }
    }
};
</script>

<style>
</style>
