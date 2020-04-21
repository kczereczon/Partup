<template>
<div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12 pb-3 pt-3">
                <groups-container/>
                <courses-container v-on:refresh="getGroups" :groups="groups"/>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-12 pb-3 pt-3 justify-content-center text-center">
                <h4>Courses</h4>
                <homework-creator :courses="courses" />
                <exams-creator :courses="courses"/>
                <hr>
                <h4>Groups</h4>
                <news-creator :groups="groups" />
            </div>
        </div>
    </div>
</div>
</template>
<script>
import axios from "axios";
export default {
    data() {
        return {
            groups: [],
            courses: [],
        };
    },
    mounted() {

        this.getGroups();
        this.getCourses();
    },
    methods: {
        getGroups() {
            this.$http
                .get("/v1/groups/all")
                .then(results => {
                    this.groups = results.data;
                })
                .catch(error => console.log(error.response)).finally(()=>{
                    this.$refs['groupContainer'].$refs['loader'].hide()
                });
        },
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
