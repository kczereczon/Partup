<template>
    <div class="col-12">
        <div class="card my-2">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{homework.name}}</h5>
            </div>
            <div class="card-body">
                {{homework.requirements}}
                <br>
                {{homework.description}}
                <br>
                {{homework.deadline}}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["homework"],
};
</script>

<style></style>
