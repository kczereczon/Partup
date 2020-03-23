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
                        :key="index"
                        :name="course.name"
                        :groups="groups"
                        :group="course.group || {}"
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
    methods: {
        addNew() {
            this.courses.unshift({});
        }
    }
};
</script>

<style></style>
