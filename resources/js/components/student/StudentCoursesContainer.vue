<template>
    <div class="row justify-content-center">
        <div class="col-md-11 col-sm-12">
            <div class="card my-3">
                <div class="card-header">
                    Courses
                </div>
                <div class="card-body">
                    <div class="row">
                            <student-courses-component
                                v-for="(course) in courses"
                                :key="course.id"
                                :id="course.id"
                                :name="course.name"
                            />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            courses: []
        };
    },
    created() {
        this.getCourses();
    },
    methods: {
        getCourses() {
            this.$http
                .get("/v1/course")
                .then(results => {
                    this.courses = results.data;
                })
                .catch(error => console.log(error.response));
        }
    }
};
</script>

<style></style>
