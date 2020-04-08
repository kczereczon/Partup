<template>
    <div class="col-12">
        <div class="card  my-1">
            <div class="card-header bg-success">
                <h5 class="mb-0">{{news.title}}</h5>
            </div>
            <div class="card-body">
                {{news.message}}
            </div>
        </div>


    </div>
</template>
<script>
export default {
    props: ["news"],
};
</script>

<style></style>
