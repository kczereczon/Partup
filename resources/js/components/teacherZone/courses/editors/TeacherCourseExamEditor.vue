<template>
    <!-- Modal -->
    <div
        class="modal fade text-center text-body"
        :id="'examEditorModal'+exam.id"
        tabindex="-1"
        role="dialog"
        aria-labelledby="webHooksModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="webHooksModalLabel">Editing Exam {{exam.name}}</h5>
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
                        <textarea v-model="place" name="place" type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <datetime
                            v-model="time"
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
                        @click="editExam"
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
    props: ["exam"],
    data() {
        return {
            name: this.exam.name,
            range_of_knowlage: this.exam.range_of_knowlage,
            description: this.exam.description,
            place: this.exam.place,
            time: new Date(this.exam.time).toISOString(),
            course_id: this.exam.course_id
        }
    },
    methods: {
        editExam() {
            this.$http
                .patch("/v1/teacher/course/exam/"+this.exam.id, {
                    id: this.exam.id,
                    name: this.name,
                    range_of_knowlage: this.range_of_knowlage,
                    description: this.description,
                    place: this.place,
                    time: moment(this.time).format("YYYY:MM:DD HH:mm:ss"),
                    course_id: this.course_id
                })
                .then(result => {
                    this.clearModal();
                    this.$emit("refresh");
                })
                .catch(err => {});
        },
        clearModal() {
            this.name = this.exam.name;
            this.range_of_knowlage = this.exam.range_of_knowlage;
            this.description = this.exam.description;
            this.place = this.exam.place;
            this.time = new Date(this.exam.time).toISOString();
        }
    }
};
</script>
