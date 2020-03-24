<template>
    <div class="container-fluid">
        <group-container />
        <courses-container v-on:refresh="getGroups" :groups="groups" />
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            groups: []
        };
    },
    mounted() {
        this.getGroups();
    },
    methods: {
        getGroups() {
            this.$http
                .get("/v1/groups/all")
                .then(results => {
                    this.groups = results.data;
                })
                .catch(error => console.log(error.response));
        }
    }
};
</script>

<style></style>
