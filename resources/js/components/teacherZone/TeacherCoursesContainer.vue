<template>
    <div class="row">
        <teacher-courses-component
            v-for="(course) in courses"
            v-bind:course="course"
            :key="course.id"
        />
    </div>
</template>
<script>
import moment from "moment";
export default {
    props: ["courses"],
    data() {
        return {
            courses: []
        };
    }
};
</script>
