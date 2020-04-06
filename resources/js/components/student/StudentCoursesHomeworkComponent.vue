<template>
    <div class="col-12">
        <div class="card my-1">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{name}}</h5>
            </div>
            <div class="card-body">
                {{requirements}}
                <br>
                {{description}}
                <br>
                {{deadline}}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["id", "name", "requirements", "description", "deadline"],
};
</script>

<style></style>
