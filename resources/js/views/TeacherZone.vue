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
                                    :courses="courses.data"
                                    @refresh="getCourses"
                                />
                                <loader v-if="loading" />
                                <paginator :path="courses.path"
                                    :currentPage="courses.current_page"
                                    :total="courses.total"
                                    :firstPage="courses.first_page_url"
                                    :lastPage="courses.last_page_url"
                                    :perPage="courses.per_page"
                                    @getPaginate="getCourses"
                                    />
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
            courses: [],
            loading: true,
        };
    },
    created() {
        this.getCourses(1);
    },
    methods: {
        getCourses(page) {
            this.loading = true;
            this.courses = null;
            this.$http
                .get("/v1/teacher/course/"+moment(new Date().toString()).format('YYYY:MM:DD__HH:mm:ss')+'?page='+page)
                .then(results => {
                    this.courses = results.data;
                })
                .catch(error => console.log(error.response))
                .finally(() => {
                    this.loading = false;
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
