<template>
    <div class="row justify-content-center">
        <div class="col-md-11 col-sm-12">
            <div class="card my-3">
                <div class="card-header">
                    Groups
                </div>
                <div class="card-body">
                    <div class="row">
                        <student-groups-component
                            v-for="(group) in groups"
                            v-bind:group="group"
                            :key="group.id"
                        />
                    </div>
                    <loader v-if="loading"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment'
export default {

    data() {
        return {
            groups: [],
            loading: true,
        };
    },
    created() {
        this.getGroups();
    },
    methods: {
        getGroups() {
            this.loading=true;
            this.$http
                .get("v1/user/groups/"+moment(new Date().toString()).format('YYYY:MM:DD__HH:mm:ss'))
                .then(results => {
                    this.groups = results.data;
                })
                .catch(error => console.log(error.response))
                .finally(() => {
                    this.loading=false;
                });
        },
    }
};
</script>

<style></style>
