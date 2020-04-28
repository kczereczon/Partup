<template>
    <div class="col-12">
        <div class="card my-1">
            <div class="card-header bg-success">
                <div class="row">
                    <div class="col-10">
                        <h5 class="mb-0 font-weight-bold">{{news.title}}</h5>
                    </div>
                    <div class="col-2 text-right">
                        <a v-on:click="shouldShowNews = !shouldShowNews" class="ml-1">
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
                <p class="font-weight-bold">Message</p>
                <p>{{news.message}}</p>
                <p class="font-weight-bold text-center">Until when to show</p>
                <p class="text-center">{{news.until_when_to_show}}</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["news"],
    data() {
        return {
            shouldShowNews: false
        };
    }
};
</script>

<style></style>
