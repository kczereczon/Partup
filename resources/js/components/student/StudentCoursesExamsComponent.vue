<template>
    <div class="col-12">
        <div class="card my-2">
            <div class="card-header bg-danger">
                <h5 class="mb-0">{{name}}</h5>
            </div>
            <div class="card-body">
                {{range_of_knowlage}}
                <br>
                {{description}}
                <br>
                {{place}}
                <br>
                {{time}}
            </div>
        </div>


    </div>
</template>
<script>
export default {
    props: ["id", "name", "range_of_knowlage", "description", "place", "time"],
};
</script>

<style></style>
