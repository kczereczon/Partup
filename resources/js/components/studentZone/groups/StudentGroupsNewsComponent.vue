<template>
    <div class="col-12">
        <div class="card  my-1">
            <div class="card-header bg-success">
                <div class="row">
                    <div class="col-10">
                        <h5 class="mb-0">{{news.title}}</h5>
                    </div>
                    <div class="col-2">
                        <a
                            v-on:click="shouldShowNews = !shouldShowNews"
                            class="ml-1"
                            >
                                <span
                                    :class="{
                                        'fa fa-caret-down': !shouldShowNews,
                                        'fa fa-caret-up': shouldShowNews
                                    }"
                                ></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body" v-if="shouldShowNews">
                {{news.message}}
            </div>
        </div>


    </div>
</template>
<script>
export default {
    props: ["news"],
    data() {
        return {
            shouldShowNews: false,
        };
    }
};
</script>

<style></style>
