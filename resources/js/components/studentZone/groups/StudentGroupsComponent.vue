<template>
    <div class="col-4 my-2">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h5 class="mb-0">{{group.name}}</h5>
                    </div>
                    <div class="col-2" v-if="Array.isArray(this.group.newses) && this.group.newses.length">
                        <a
                            v-on:click="shouldShowGroup = !shouldShowGroup"
                            class="ml-1"
                            >
                                <span
                                    :class="{
                                        'fa fa-caret-down': !shouldShowGroup,
                                        'fa fa-caret-up': shouldShowGroup
                                    }"
                                ></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light" v-if="shouldShowGroup">
                <div class="row no-gutters">
                    <student-groups-news-component
                        v-for="(news) in newses"
                        v-bind:news="news"
                        :key="news.id"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["group"],
    data() {
        return {
            shouldShowGroup: true,
            newses:this.group.newses,
        };
    },
    created() {
        this.closeGroup();
    },
    methods: {
        closeGroup() {
            //closing course if there is no exmas/homeworks
            if(!(Array.isArray(this.group.newses) && this.group.newses.length))
            {
                this.shouldShowGroup=false;
            }
        }
    }
};
</script>

<style></style>
