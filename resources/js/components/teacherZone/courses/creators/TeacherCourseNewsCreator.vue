<template>
    <div style="display:inline;">
        <a
            data-toggle="modal"
            :data-target="'#newsModal'+course.id"
            class="ml-1 bg-success px-2 py-1 rounded-circle"
        >
            <span class="fa fa-plus"></span>
        </a>
        <!-- Modal -->
        <div
            class="modal fade text-center"
            :id="'newsModal'+course.id"
            tabindex="-1"
            role="dialog"
            aria-labelledby="webHooksModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            class="modal-title"
                            id="webHooksModalLabel"
                        >Setting up News for {{course.name}}</h5>
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
import moment from "moment";
import Swal from "sweetalert2";
import { Datetime } from "vue-datetime";
import "vue-datetime/dist/vue-datetime.css";
Vue.use(Datetime);
export default {
    props: ["course"],
    date() {
        return {
            title: "",
            message: "",
            until_when_to_show: ""
        };
    },
    methods: {
        createNews() {
            this.$http
                .post("/v1/course/news", {
                    title: this.title,
                    message: this.message,
                    course_id: this.course.id,
                    until_when_to_show: moment(this.until_when_to_show).format(
                        "YYYY:MM:DD HH:mm:ss"
                    )
                })
                .then(result => {
                    this.refresh();
                    this.clearModal();
                    Swal.fire({
                        icon: "success",
                        title: "Created News",
                        showConfirmButton: false,
                        timer: 2000,
                        scrollbarPadding:false,
                        timerProgressBar: true
                    });
                })
                .catch(err => {});
        },
        clearModal() {
            this.title = "";
            this.message = "";
            this.until_when_to_show = "";
        },
        refresh() {
            this.$emit("refresh");
        }
    }
};
</script>
