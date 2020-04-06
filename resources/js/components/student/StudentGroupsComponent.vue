<template>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{name}}</h5>
        </div>
        <div class="card-body bg-light">
            <div class="row no-gutters">
                <student-groups-news-component
                    v-for="(news) in newses"
                    :key="news.id"
                    :id="news.id"
                    :title="news.title"
                    :message="news.message"
                />
            </div>
        </div>
    </div>

</template>
<script>
export default {
    props: ["id", "name"],
    data() {
        return {
            newses: []
        };
    },
    created() {
        this.getNewses();
    },
    methods: {
        getNewses() {
            this.$http
                .get("v1/groups/{id}/news/".replace('{id}',this.id))
                .then(result=>{
                    this.newses=result.data;
                })
                .catch(error => console.log(error.response));
        }
    }
};
</script>

<style></style>
