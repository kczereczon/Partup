<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success">
                <h5 class="mb-0">{{title}}</h5>
            </div>
            <div class="card-body">
                {{message}}
            </div>
        </div>


    </div>
</template>
<script>
export default {
    props: ["id", "title", "message"],
};
</script>

<style></style>
