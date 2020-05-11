<template>
    <button type="button" class="btn">
        {{group.name}}
    </button>
</template>
<script>
export default {
    props: ["group"],
    data() {
        return {
            group: this.group,
        };
    }
};
</script>

<style></style>
