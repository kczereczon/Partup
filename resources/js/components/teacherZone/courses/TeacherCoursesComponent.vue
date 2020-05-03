<template>
    <div class="col-md-12 col-xl-6 my-2">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h5 class="mb-0">{{course.group.name}} | {{course.name}}</h5>
                    </div>
                    <div class="col-12 col-sm-6 mt-1 text-right">
                        <div class="row">
                            <div class="col">
                                <teacher-course-news-creator
                                    :course="course"
                                    @refresh="refresh"
                                />
                                <teacher-course-homework-creator
                                    :course="course"
                                    @refresh="refresh"
                                />
                                <teacher-course-exam-creator
                                    :course="course"
                                    @refresh="refresh"
                                />
                                <a
                                    v-on:click="shouldShowCourse = !shouldShowCourse"
                                    v-if="(Array.isArray(this.course.exams))"
                                    class="px-1"
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
                </div>
            </div>
            <div class="card-body bg-light" v-if="shouldShowCourse">
                <div class="row no-gutters">
                    <teacher-courses-exams-component
                        v-for="(exam) in exams"
                        v-bind:exam="exam"
                        :key="exam.id"
                        @refresh="refreshExams"
                    />
                    <teacher-courses-homework-component
                        v-for="(homework) in homeworks"
                        v-bind:homework="homework"
                        :key="homework.id"
                        @refresh="refreshHomeworks"
                    />
                    <teacher-courses-news-component
                        v-for="(news) in newses"
                        v-bind:news="news"
                        :key="news.id"
                        @refresh="refreshNews"
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
            homeworks: this.course.homeworks,
            newses: this.course.newses
        };
    },
    methods: {
        refreshExams() {
            this.$emit("refresh");
            this.exam.id+=1;
        },
        refreshHomeworks() {
            this.$emit("refresh");
            this.homework.id+=1;
        },
        refreshNews() {
            this.$emit("refresh");
            this.news.id+=1;
        }
    }
};
</script>

<style></style>
