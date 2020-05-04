<template>
    <div class="row">
        <teacher-courses-component
            v-for="(course) in courses"
            v-bind:course="course"
            :key="course.id"
            @refresh="refresh"
        />
    </div>
</template>
<script>
import moment from "moment";
export default {
    props: ["courses"],
    methods: {
        refresh(){
            this.$emit("refresh");
        }
    }
};
</script>
