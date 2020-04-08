<template>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{course.name}}</h5>
            </div>
            <div class="card-body bg-light">
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
            exams: this.course.exams,
            homeworks: this.course.homeworks
        };
    }
};
</script>

<style></style>
