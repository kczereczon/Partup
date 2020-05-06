<template>
    <div class="col-12">
        <div class="card my-2">
            <div class="card-header bg-danger text-white">
                <div class="row">
                    <div class="col-9">
                        <h5 class="mb-0 font-weight-bold">{{exam.name}}</h5>
                    </div>
                    <div class="col-3 text-right">
                        <div class="row">
                            <div class="col">
                                <a
                                    v-on:click="removeExam"
                                    v-if="shouldShowExams && canEdit"
                                    class="ml-1"
                                >
                                    <span class="fa fa-minus"></span>
                                </a>
                                <a
                                    v-if="shouldShowExams && canEdit"
                                    data-toggle="modal"
                                    :data-target="'#examEditorModal'+exam.id"
                                    class="ml-1"
                                >
                                    <span class="fa fa-pen"></span>
                                </a>
                                <!-- Editor Modal -->
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
                                                <h5
                                                    class="modal-title"
                                                    id="webHooksModalLabel"
                                                >Editing Exam {{exam.name}}</h5>
                                                <button
                                                    type="button"
                                                    class="close"
                                                    data-dismiss="modal"
                                                    aria-label="Close"
                                                >
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input
                                                        v-model="name"
                                                        name="name"
                                                        type="text"
                                                        class="form-control"
                                                    />
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
                                <a v-on:click="shouldShowExams = !shouldShowExams" class="ml-1">
                                    <span
                                        :class="{
                                        'fa fa-caret-down': !shouldShowExams,
                                        'fa fa-caret-up': shouldShowExams
                                    }"
                                    ></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body font-weight-bold" v-if="shouldShowExams">
                <p class="font-weight-bold">Knowladge needed</p>
                <p class="font-weight-normal">{{exam.range_of_knowlage}}</p>
                <p class="font-weight-bold">Description</p>
                <p class="font-weight-normal">{{exam.description}}</p>
                <div class="container">
                    <div class="row font-weight-bold text-center">
                        <div class="col-sm-12 col-md-6">
                            <p class="font-weight-bold">Place</p>
                            <p class="font-weight-normal">{{exam.place}}</p>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <p class="font-weight-bold">Time</p>
                            <p class="font-weight-normal">{{exam.time}}</p>
                        </div>
                    </div>
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
            shouldShowExams: false,
            canEdit: false,
            name: this.exam.name,
            range_of_knowlage: this.exam.range_of_knowlage,
            description: this.exam.description,
            place: this.exam.place,
            time: new Date(this.exam.time).toISOString(),
            course_id: this.exam.course_id
        };
    },
    mounted() {
        if (sessionStorage.getItem("authUser")) {
            this.todos = JSON.parse(sessionStorage.getItem("authUser"));
            if (this.news.teacher_id == this.todos.id) {
                this.canEdit = true;
            }
        }
    },
    methods: {
        removeExam() {
            if (confirm("Remove selected Exam?")) {
                this.$http
                    .delete("/v1/teacher/course/exam/" + this.exam.id, {
                        id: this.exam.id
                    })
                    .then(result => {
                        this.refresh();
                    })
                    .catch(err => {});
            }
        },
        editExam() {
            this.$http
                .patch("/v1/teacher/course/exam/" + this.exam.id, {
                    id: this.exam.id,
                    name: this.name,
                    range_of_knowlage: this.range_of_knowlage,
                    description: this.description,
                    place: this.place,
                    time: moment(this.time).format("YYYY:MM:DD HH:mm:ss"),
                    course_id: this.exam.course_id
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
        },
        refresh() {
            this.$emit("refresh");
        }
    }
};
</script>
