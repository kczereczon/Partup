<template>
    <div class="col-4 my-2">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{group.name}}</h5>
            </div>
            <div class="card-body bg-light">
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
            newses:this.group.newses
        };
    }
};
</script>

<style></style>
