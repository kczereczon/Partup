<template>
    <div ref="loader" class="loader">
        <p class="loading">Loading ...</p>
    </div>
</template>

<script>
var dots = "";
export default {
    data() {
        return {
            groups: []
        };
    },
    methods: {
        hide() {
            $("#" + this.$refs.loader.id).fadeOut("slow");
        }
    },
    mounted: {}
};
</script>

<style>
.loader {
    display: flex;
    width: 100%;
    height: 100%;
    justify-content: center;
    align-items: center;
}
.loading {
    font-size: 2em;
    color: var(--gray);
    font-weight: bolder;
}
</style>
