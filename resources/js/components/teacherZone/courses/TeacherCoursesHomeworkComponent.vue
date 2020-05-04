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
                                    v-if="shouldShowHomework"
                                    class="ml-1"
                                >
                                    <span class="fa fa-minus"></span>
                                </a>
                                <a
                                    v-if="shouldShowHomework"
                                    data-toggle="modal"
                                    :data-target="'#homeworkEditorModal'+homework.id"
                                    class="ml-1"
                                >
                                    <span class="fa fa-pen"></span>
                                </a>
                                <teacher-course-homework-editor
                                    :homework="homework"
                                    @refresh="refresh"
                                />
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
export default {
    props: ["homework"],
    data() {
        return {
            shouldShowHomework: false
        };
    },
    methods: {
        removeHomework() {
            if (confirm("Remove selected Homework?")) {
                this.$http
                    .delete("/v1/teacher/course/homework/"+this.homework.id, {
                        id: this.homework.id
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

<style></style>
