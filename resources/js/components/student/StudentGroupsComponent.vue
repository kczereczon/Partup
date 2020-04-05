<template>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{name}}</h5>
        </div>
        <div class="card-body bg-light">
            <div class="row no-gutters">
                <student-groups-news-component/>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    props: ["id", "name"],
    data() {
        return {
            news: []
        };
    },
    created() {
        this.getNews();
    },
    methods: {
        getNews() {
            this.$http
                .get("v1/groups/{id}/news/".replace('{id}',this.id))
                .then(result=>{
                    this.news=result.data;
                })
                .catch(error => console.log(error.response));
        }
    }
};
</script>

<style></style>
