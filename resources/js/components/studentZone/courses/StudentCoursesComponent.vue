<template>
    <div class="col-md-12 col-xl-6 my-2">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h5 class="mb-0">{{course.name}}</h5>
                    </div>
                    <div
                        class="col-2 text-right"
                        v-if="(Array.isArray(this.course.exams) && this.course.exams.length || Array.isArray(this.course.homeworks) && this.course.homeworks.length)"
                    >
                        <a v-on:click="shouldShowCourse = !shouldShowCourse" class="ml-1">
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
                        :key="exam.id+'cexam'"
                    />
                    <student-courses-homework-component
                        v-for="(homework) in homeworks"
                        v-bind:homework="homework"
                        :key="homework.id+'chomework'"
                    />
                    <student-courses-news-component
                        v-for="(news) in newses"
                        v-bind:news="news"
                        :key="news.id+'cnews'"
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
    created() {
        this.closeCourse();
    },
    methods: {
        closeCourse() {
            //closing course if there is no exmas/homeworks
            if (
                !(
                    (Array.isArray(this.course.exams) &&
                        this.course.exams.length) ||
                    (Array.isArray(this.course.homeworks) &&
                        this.course.homeworks.length) ||
                    (Array.isArray(this.course.newses) &&
                        this.course.newses.length)
                )
            ) {
                this.shouldShowCourse = false;
            }
        }
    }
};
</script>

<style></style>
