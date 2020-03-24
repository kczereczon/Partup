<template>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="mt-auto mb-auto col-6">Courses</div>
                        <div class="col-6 text-right">
                            <a v-on:click="addNew()" class>
                                <span class="fa fa-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <course-component
                        v-for="(course, index) in courses"
                        :key="course.id"
                        :group="course.group || {}"
                        :class="{ 'mt-3': index != 0 }"
                        :name="course.name"
                        :groups="groups"
                        :id="course.id"
                        :new="course.new"
                        @refresh="getCourses"
                        @removeCourseFromArray="removeCourseFromArray"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["groups"],
    data() {
        return { courses: [] };
    },
    created() {
        this.getCourses();
    },
    methods: {
        getCourses() {
            this.$http
                .get("/v1/course")
                .then(result => {
                    this.courses = result.data;
                })
                .catch(err => {});
        },
        addNew() {
            if (!this.courses[0] || !this.courses[0].new)
                this.courses.unshift({ name: "", group: [], new: true, id: 0 });
        },
        removeCourseFromArray(course_id) {
            console.log(course_id);
            this.courses.splice(course_id, 1);
        }
    }
};
</script>

<style></style>
