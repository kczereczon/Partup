<template>
    <div class="col-12">
        <div class="card my-2">
            <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-9">
                        <h5 class="mb-0 font-weight-bold">{{homework.name}}</h5>
                    </div>
                    <div class="col-3 text-right">
                        <div class="row">
                            <div class="col">
                                <a
                                    v-on:click="removeHomework"
                                    v-if="shouldShowHomework && canEdit"
                                    class="ml-1"
                                >
                                    <span class="fa fa-minus"></span>
                                </a>
                                <a
                                    v-if="shouldShowHomework && canEdit"
                                    data-toggle="modal"
                                    :data-target="'#homeworkEditorModal'+homework.id"
                                    class="ml-1"
                                >
                                    <span class="fa fa-pen"></span>
                                </a>
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
                                                    <label for="name">Name of homework</label>
                                                    <input
                                                        v-model="name"
                                                        name="name"
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
                                <a
                                    v-on:click="shouldShowHomework = !shouldShowHomework"
                                    class="ml-1"
                                >
                                    <span
                                        :class="{
                                        'fa fa-caret-down': !shouldShowHomework,
                                        'fa fa-caret-up': shouldShowHomework
                                    }"
                                    ></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" v-if="shouldShowHomework">
                <p class="font-weight-bold">Requirements</p>
                <p>{{homework.requirements}}</p>
                <p class="font-weight-bold">Description</p>
                <p>{{homework.description}}</p>
                <p class="font-weight-bold text-center">Deadline</p>
                <p class="text-center">{{homework.deadline}}</p>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import Swal from "sweetalert2";
import { Datetime } from "vue-datetime";
import "vue-datetime/dist/vue-datetime.css";
Vue.use(Datetime);
export default {
    props: ["homework"],
    data() {
        return {
            shouldShowHomework: false,
            canEdit: this.homework.owner,
            name: this.homework.name,
            description: this.homework.description,
            requirements: this.homework.requirements,
            where_send: this.homework.where_send,
            deadline: new Date(this.homework.deadline).toISOString()
        };
    },
    methods: {
        removeHomework() {
            Swal.fire({
                title: "Are you sure?",
                text: "Homework "+this.homework.name+" will be gone forever!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
                scrollbarPadding: false
            }).then(result => {
                if (result.value)
                {
                    this.$http
                    .delete("/v1/teacher/course/homework/" + this.homework.id, {
                        id: this.homework.id
                    })
                    .then(result => {
                        Swal.fire({
                                title: "Deleted!",
                                text: "Homework has been deleted.",
                                icon: "success",
                                timer: 2000,
                                timerProgressBar: true,
                        });
                        this.refresh();
                    })
                    .catch(err => {});
                }
            });
        },
        editHomework() {
            this.$http
                .patch("/v1/teacher/course/homework/" + this.homework.id, {
                    id: this.homework.id,
                    name: this.name,
                    description: this.description,
                    requirements: this.requirements,
                    where_send: this.where_send,
                    deadline: moment(this.deadline).format(
                        "YYYY:MM:DD HH:mm:ss"
                    ),
                    course_id: this.homework.course_id
                })
                .then(result => {
                    this.clearModal();
                    this.refresh();
                    Swal.fire({
                        icon: "success",
                        title: "Edited Homework",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        scrollbarPadding:false,
                    });
                })
                .catch(err => {
                    Swal.fire({
                        icon: "error",
                        title: "Error Occured",
                        text: error.response.data.error,
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        scrollbarPadding:false,
                    });
                });
        },
        clearModal() {
            this.name = this.homework.name;
            this.description = this.homework.description;
            this.requirements = this.homework.requirements;
            this.where_send = this.homework.where_send;
            this.deadline = new Date(this.homework.deadline).toISOString();
        },
        refresh() {
            this.$emit("refresh");
        }
    }
};
</script>

<style></style>
