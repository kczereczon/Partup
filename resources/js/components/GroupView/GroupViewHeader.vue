<template>
    <div class="row">
        <div class="col-8">
            <nav aria-label="breadcrumb" class="h-100">
                <ol class="breadcrumb h-100 my-0 px-0 py-0" style="background:none;">
                    <li
                        v-for="parent in flat"
                        :key="parent.id"
                        :class="['breadcrumb-item', {'active': parent.active}]"
                    >
                        <a
                            v-if="!parent.active"
                            @click="redirectToGroup(parent.id, $event)"
                            href="#"
                            class="px-2 py-2"
                            style="font-size: 1.125rem;"
                        >{{parent.name}}</a>
                        <span
                            v-if="parent.active"
                            style="font-size: 1.125rem;"
                            class="px-2 py-2 text-dark"
                        >{{parent.name}}</span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-4 text-right">
            <a @click="editName()" class="ml-1" v-if="shouldShowGroupData">
                <span class="fa fa fa-pen"></span>
            </a>
            <a class="ml-1" @click="editWebHooks()" v-if="shouldShowGroupData">
                <span class="fa fa-gear"></span>
            </a>
            <a class="ml-1" @click="changeShowGroupData()">
                <span
                    :class="{
                    'fa fa-caret-down': !shouldShowGroupData,
                    'fa fa-caret-up': shouldShowGroupData
                }"
                ></span>
            </a>
        </div>
    </div>
</template>
<script>
import Swal from "sweetalert2";
export default {
    props: ["group", "shouldShowGroupData"],
    data() {
        return {
            flat: [],
            name: "",
            error: [],
        };
    },
    created() {
        this.group.active = true;
        this.flatten(this.$props.group);
        this.flat.reverse();
    },
    methods: {
        redirectToGroup(idGrupy, event) {
            event.preventDefault();
            this.$router.push({ name: "GroupView", params: { id: idGrupy } });
            this.$emit("refresh");
        },
        flatten(el) {
            this.flat.push(el);
            if (el.group) {
                this.flatten(el.group);
            }
        },
        changeShowGroupData() {
            this.$emit("changeShowGroupData");
        },
        editWebHooks() {
            var homework_webhook = "";
            var news_webhook = "";
            var exams_webhook = "";
            if (!!this.group.homework_webhook)
                homework_webhook = this.group.homework_webhook;
            if (!!this.group.news_webhook)
                news_webhook = this.group.news_webhook;
            if (!!this.group.exams_webhook)
                exams_webhook = this.group.exams_webhook;
            Swal.fire({
                title: "Web hook editor for " + this.group.name,
                html:
                    '<label class="mt-3">Homework Webhook</label><input id="homework_webhook" value="' +
                    homework_webhook +
                    '" type="text" class="form-control mb-3"/>' +
                    '<label>News Webhook</label><input id="news_webhook" value="' +
                    news_webhook +
                    '" type="text" class="form-control mb-3"/>' +
                    '<label>Exam Webhook</label><input id="exams_webhook" value="' +
                    exams_webhook +
                    '" type="text" class="form-control mb-3"/>',
                showCancelButton: true,
                confirmButtonText: "Update Webhooks!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
                allowOutsideClick: false,
                scrollbarPadding: false
            }).then(result => {
                if (!!result.value)
                    this.$http
                        .patch("/v1/group/" + this.group.id, {
                            name: this.group.name,
                            homework_webhook: document.getElementById(
                                "homework_webhook"
                            ).value,
                            news_webhook: document.getElementById(
                                "news_webhook"
                            ).value,
                            exams_webhook: document.getElementById(
                                "exams_webhook"
                            ).value
                        })
                        .then(results => {
                            this.refresh();
                            Swal.fire({
                                title: "Updated!",
                                text: "Webhooks has been updated.",
                                icon: "success",
                                timer: 2000,
                                timerProgressBar: true,
                                scrollbarPadding: false
                            });
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Something, went wrong.",
                                showConfirmButton: true
                            });
                        });
            });
        },
        editName() {
            Swal.fire({
                title: "Change Group name from " + this.group.name,
                html:
                    '<label>New Name</label><input id="groupName" type="text" class="form-control mb-3"/>',
                showCancelButton: true,
                confirmButtonText: "Update Name!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
                allowOutsideClick: false,
                scrollbarPadding: false
            }).then(result => {
                if (!!result.value)
                    this.$http
                        .patch("/v1/group/" + this.group.id, {
                            name: document.getElementById("groupName").value
                        })
                        .then(results => {
                            this.refresh();
                            Swal.fire({
                                title: "Updated!",
                                text: "Name has been changed.",
                                icon: "success",
                                timer: 2000,
                                timerProgressBar: true,
                                scrollbarPadding: false
                            });
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Something, went wrong.",
                                showConfirmButton: true
                            });
                        });
            });
        },
        refresh() {
            //refresh data in memory
        }
    }
};
</script>
<style></style>
