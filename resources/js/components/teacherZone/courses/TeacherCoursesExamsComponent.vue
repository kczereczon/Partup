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
                                <a v-on:click="removeExam" v-if="shouldShowExams" class="ml-1">
                                    <span class="fa fa-minus"></span>
                                </a>
                                <a
                                    v-if="shouldShowExams"
                                    data-toggle="modal"
                                    :data-target="'#examEditorModal'+exam.id"
                                    class="ml-1"
                                >
                                    <span class="fa fa-pen"></span>
                                </a>
                                <teacher-course-exam-editor :exam="exam" @refresh="refresh" />
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
export default {
    props: ["exam"],
    data() {
        return {
            shouldShowExams: false
        };
    },
    methods: {
        removeExam() {
            if (confirm("Remove selected Exam?")) {
                this.$http
                    .delete("/v1/teacher/course/exam/", {
                        id: this.exam.id
                    })
                    .then(result => {
                        this.refresh();
                    })
                    .catch(err => {});
            }
        },
        refresh() {
            this.$emit("refresh");
        }
    }
};
</script>
