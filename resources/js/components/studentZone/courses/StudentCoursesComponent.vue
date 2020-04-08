<template>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h5 class="mb-0">{{course.name}}</h5>
                    </div>
                    <div class="col-2" v-if="(Array.isArray(this.course.exams) && this.course.exams.length || Array.isArray(this.course.homeworks) && this.course.homeworks.length)">
                        <a
                            v-on:click="shouldShowCourse = !shouldShowCourse"
                            class="ml-1"
                            >
                                <span
                                    :class="{
                                        'fa fa-caret-down': !shouldShowCourse,
                                        'fa fa-caret-up': shouldShowCourse
                                    }"
                                ></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light" v-if="shouldShowCourse">
                <div class="row no-gutters">
                    <student-courses-exams-component
                        v-for="(exam) in exams"
                        v-bind:exam="exam"
                        :key="exam.id"
                    />
                    <student-courses-homework-component
                        v-for="(homework) in homeworks"
                        v-bind:homework="homework"
                        :key="homework.id"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["course"],
    data() {
        return {
            shouldShowCourse: true,
            exams: this.course.exams,
            homeworks: this.course.homeworks
        };
    },
    created() {
        this.closeCourse();
    },
    methods: {
        closeCourse() {
            //closing course if there is no exmas/homeworks
            if(!(Array.isArray(this.course.exams) && this.course.exams.length || Array.isArray(this.course.homeworks) && this.course.homeworks.length))
            {
                this.shouldShowCourse=false;
            }
        }
    }
};
</script>

<style></style>
