<template>
    <div
        class="modal fade text-center"
        :id="'newsEditorModal'+news.id"
        tabindex="-1"
        role="dialog"
        aria-labelledby="webHooksModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="webHooksModalLabel">Editing News {{news.title}}</h5>
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
                        <label for="message">Description</label>
                        <textarea
                            v-model="message"
                            name="message"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <label for="until_when_to_show">Until when to show</label>
                        <datetime
                            v-model="until_when_to_show"
                            type="datetime"
                            input-class="form-control text-center"
                            :minute-step="5"
                        ></datetime>
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
                        @click="editNews"
                        data-dismiss="modal"
                    >Apply</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import { Datetime } from "vue-datetime";
import "vue-datetime/dist/vue-datetime.css";
Vue.use(Datetime);
export default {
    props: ["news"],
    data() {
        return {
            title: this.news.title,
            message: this.news.message,
            until_when_to_show: new Date(
                this.news.until_when_to_show
            ).toISOString()
        };
    },
    methods: {
        editNews() {
            this.$http
                .patch("/v1/course/news/"+this.news.id, {
                    id: this.news.id,
                    title: this.title,
                    message: this.message,
                    until_when_to_show: moment(this.until_when_to_show).format(
                        "YYYY:MM:DD HH:mm:ss"
                    ),
                    course_id: this.news.course_id
                })
                .then(result => {
                    this.clearModal();
                    this.$emit("refresh");
                })
                .catch(err => {});
        },
        clearModal() {
            this.title = this.news.title;
            this.message = this.news.message;
            this.until_when_to_show = new Date(
                this.news.until_when_to_show
            ).toISOString();
        }
    }
};
</script>
