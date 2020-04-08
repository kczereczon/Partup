<template>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{name}}</h5>
            </div>
            <div class="card-body bg-light">
                <div class="row no-gutters">
                    <student-courses-exams-component
                        v-for="(exam) in exams"
                        :key="exam.id"
                        :id="exam.id"
                        :name="exam.name"
                        :range_of_knowlage="exam.range_of_knowlage"
                        :description="exam.description"
                        :place="exam.place"
                        :time="exam.time"
                    />
                    <student-courses-homework-component
                        v-for="(homework) in homeworks"
                        :key="homework.id"
                        :id="homework.id"
                        :name="homework.name"
                        :requirements="homework.requirements"
                        :description="homework.description"
                        :deadline="homework.deadline"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["id", "name"],
    data() {
        return {
            exams: [],
            homeworks: []
        };
    },
    created() {
        this.getExams();
        this.getHomeworks();
    },
    methods: {
        getExams() {
            this.$http
                .get("v1/course/{id}/exams".replace('{id}',this.id))
                .then(result=>{
                    this.exams=result.data;
                })
                .catch(error => console.log(error.response));
        },
        getHomeworks() {
            this.$http
                .get("v1/course/{id}/homeworks".replace('{id}',this.id))
                .then(result=>{
                    this.homeworks=result.data;
                })
                .catch(error => console.log(error.response));
        }
    }
};
</script>

<style></style>
