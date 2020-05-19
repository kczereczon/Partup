<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-4 align-self-center">Students List</div>
                <div class="col-5 text-center align-self-center">
                    <b>
                        <u>Students total</u>
                        : {{this.group.students.length}}
                    </b>
                </div>
                <div class="col-3 text-right align-self-center">
                    <a
                        class="ml-1"
                        @click="changeShowStudents()"
                        v-if="this.group.students.length!=0"
                    >
                        <span
                            :class="{
                                        'fa fa-caret-down': !shouldShowStudents,
                                        'fa fa-caret-up': shouldShowStudents
                                    }"
                        ></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="body text-center" v-if="shouldShowStudents && this.group.students.length!=0">
            <div class="container second mb-3">
                <div class="row mt-3 mx-1">
                    <div class="col text-center">
                        <b>E-mail</b>
                    </div>
                    <div class="col text-center">
                        <b>Name</b>
                    </div>
                </div>
                <hr />
                <div
                    class="row data mx-1"
                    v-for="(student) in this.group.students"
                    :key="'s'+student.id"
                >
                    <div class="col text-center">{{student.user.email}}</div>

                    <div class="col text-center">{{student.user.name}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
export default {
    props: ["group"],
    data() {
        return {
            shouldShowStudents: true
        };
    },
    methods: {
        changeShowStudents() {
            this.shouldShowStudents = !this.shouldShowStudents;
        }
    }
};
</script>

<style>
</style>
