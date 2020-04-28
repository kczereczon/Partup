<template>
    <div class="col-12">
        <div class="card my-2">
            <div class="card-header bg-danger text-white">
                <div class="row">
                    <div class="col-10">
                        <h5 class="mb-0 font-weight-bold">{{exam.name}}</h5>
                    </div>
                    <div class="col-2 text-right">
                        <div class="row">
                            <div class="col">
                                <a
                                    v-if="shouldShowExams"
                                    v-on:click="editMode ? save() : edit()"
                                    class="ml-1"
                                >
                                    <span
                                        :class="{
                                        'fa fa-pen': !editMode,
                                        'fa fa-save': editMode
                                    }"
                                    ></span>
                                </a>
                                <a v-on:click="shouldShowExams = !shouldShowExams" class="ml-1">
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
                </div>
            </div>
            <div class="card-body font-weight-bold" v-if="shouldShowExams">
                <p class="font-weight-bold">Knowladge needed</p>
                <p class="font-weight-normal">{{exam.range_of_knowlage}}</p>
                <p class="font-weight-bold">Description</p>
                <p class="font-weight-normal">{{exam.description}}</p>
                <div class="container">
                    <div class="row font-weight-bold text-center">
                        <div class="col-sm-12 col-md-6">
                            <p class="font-weight-bold">Place</p>
                            <p class="font-weight-normal">{{exam.place}}</p>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <p class="font-weight-bold">Time</p>
                            <p class="font-weight-normal">{{exam.time}}</p>
                        </div>
                    </div>
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
            shouldShowExams: false
        };
    },
    methods: {
        show() {
            this.shouldShowExams = true;
        }
    }
};
</script>

<style>
table {
    width: 100%;
}
th {
    width: 50%;
    text-align: center;
}
tr {
    width: 50%;
    text-align: center;
}
</style>
