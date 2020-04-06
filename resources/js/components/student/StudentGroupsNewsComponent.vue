<template>
    <div class="col-12">
        <h5>{{title}}</h5>
        {{message}}
    </div>
</template>
<script>
export default {
    props: ["id", "title", "message"],
};
</script>

<style></style>
