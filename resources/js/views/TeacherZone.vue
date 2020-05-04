<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-9 col-sm-12 pb-3 pt-3">
                <div class="row justify-content-center">
                    <div class="col-md-11 col-sm-12">
                        <div class="card my-3">
                            <div class="card-header">Courses</div>
                            <div class="card-body">
                                <teacher-courses-container
                                    :courses="courses"
                                    @refresh="getCourses"
                                />
                                <loader ref="loader" id="teacher-courses-component" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
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
            this.courses = null;
            this.$http
                .get("/v1/teacher/course/"+moment(new Date().toString()).format('YYYY:MM:DD__HH:mm:ss'))
                .then(results => {
                    this.courses = results.data;
                })
                .catch(error => console.log(error.response))
                .finally(() => {
                    this.$refs["loader"].hide();
                });
        },
        refresh() {
            this.getCourses();
        }
    }
};
</script>

<style>
</style>
