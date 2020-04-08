<template>
    <div class="col-12">
        <div class="card my-2">
            <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-10">
                        <h5 class="mb-0">{{homework.name}}</h5>
                    </div>
                    <div class="col-2">
                        <a
                            v-on:click="shouldShowHomework = !shouldShowHomework"
                            class="ml-1"
                            >
                                <span
                                    :class="{
                                        'fa fa-caret-down': !shouldShowHomework,
                                        'fa fa-caret-up': shouldShowHomework
                                    }"
                                ></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body" v-if="shouldShowHomework">
                {{homework.requirements}}
                <br>
                {{homework.description}}
                <br>
                {{homework.deadline}}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["homework"],
    data() {
        return {
            shouldShowHomework: false,
        };
    }
};
</script>

<style></style>
