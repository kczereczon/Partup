<template>
    <div class="col-12">
        <div class="card my-2">
            <div class="card-header bg-danger">
                <div class="row">
                    <div class="col-10">
                        <h5 class="mb-0">{{exam.name}}</h5>
                    </div>
                    <div class="col-2">
                        <a
                            v-on:click="shouldShowExams = !shouldShowExams"
                            class="ml-1"
                            >
                                <span
                                    :class="{
                                        'fa fa-caret-down': !shouldShowExams,
                                        'fa fa-caret-up': shouldShowExams
                                    }"
                                ></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body" v-if="shouldShowExams">
                {{exam.range_of_knowlage}}
                <br>
                {{exam.description}}
                <br>
                {{exam.place}}
                <br>
                {{exam.time}}
            </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["exam"],
    data() {
        return {
            shouldShowExams: false,
        };
    },
    methods: {
        show() {
                this.shouldShowExams = true;
            }
    }
};
</script>

<style></style>
