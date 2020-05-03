<template>
    <div>
        <button class="btn btn-primary w-100 my-2" data-toggle="modal" data-target="#newsModal">
            <span class="fa fa-gear"></span> ADD NEWS
        </button>
        <!-- Modal -->
        <div
            class="modal fade"
            id="newsModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="webHooksModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="webHooksModalLabel">Setting for the group.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Name of News</label>
                            <input v-model="title" name="title" type="text" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="group_id">Group</label>
                            <select
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Group name."
                                v-model="group_id"
                            >
                                <option
                                    v-for="group in groups"
                                    :key="group.id"
                                    :value="group.id"
                                    :selected="group.id == group.id"
                                >{{ group.full_name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Description</label>
                            <textarea
                                v-model="message"
                                name="message"
                                type="text"
                                class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label for="until_when_to_show" >Until when to show</label>
                            <datetime v-model="until_when_to_show" type="datetime" input-class="form-control text-center" :minute-step="5"></datetime>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            @click="clearModal"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >Close</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="createNews"
                            data-dismiss="modal"
                        >Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//date time picker
import moment from 'moment'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
Vue.use(Datetime);

export default {
    props: ["groups"],
    date() {
        return {
            title: "",
            message: "",
            group_id: "",
            until_when_to_show: ""
        };
    },
    methods: {
        createNews() {
            this.$http
                .post("/v1/group/news", {
                    title: this.title,
                    message: this.message,
                    group_id: this.group_id,
                    until_when_to_show: moment(this.until_when_to_show).format('YYYY:MM:DD HH:mm:ss'),
                })
                .then(result => {
                    this.refreshCourses();
                    this.clearModal();
                })
                .catch(err => {});
        },
        clearModal() {
            this.title = "";
            this.message = "";
            this.group_id = "";
            this.until_when_to_show = "";
        }
    }
};
</script>

<style>
</style>
