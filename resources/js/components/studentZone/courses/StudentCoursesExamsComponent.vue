<template>
    <div class="col-12">
        <div class="card my-2">
            <div class="card-header bg-danger">
                <h5 class="mb-0">{{exam.name}}</h5>
            </div>
            <div class="card-body">
                {{exam.range_of_knowlage}}
                <br>
                {{exam.description}}
                <br>
                {{exam.place}}
                <br>
                {{exam.time}}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["exam"],
};
</script>

<style></style>
