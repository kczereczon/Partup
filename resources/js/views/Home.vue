<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <group-container />
                <courses-container v-on:refresh="getGroups" :groups="groups" />
            </div>

            <homework-creator :courses="courses" />
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            groups: [],
            courses: []
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
                .catch(error => console.log(error.response));
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
