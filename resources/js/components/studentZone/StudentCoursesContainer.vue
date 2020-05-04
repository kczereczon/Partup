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
                                v-bind:course="course"
                                :key="course.id"
                            />
                            <loader v-if="loading"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment'
export default {
    data() {
        return {
            courses: [],
            loading: true,
        };
    },
    created() {
        this.getCourses();
    },
    methods: {
        getCourses() {
            this.loading=true;
            this.$http
                .get("/v1/user/course/"+moment(new Date().toString()).format('YYYY:MM:DD__HH:mm:ss'))
                .then(results => {
                    this.courses = results.data;
                })
                .catch(error => console.log(error.response))
                .finally(() => {
                    this.loading=false;
                });
        }
    }
};
</script>

<style></style>
