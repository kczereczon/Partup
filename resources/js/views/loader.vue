<template>
    <div ref="loader" class="loader">
        <!-- <p>
      <img src="../../images/loading.gif" alt="loading gif" />
        </p>-->
        <p
            style="font-size:2em; color:#606060; font-weight:bolder;"
            id="loading"
        >Loading ...</p>
    </div>
</template>

<script>
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
    }
};
</script>

<style>
.loader {
    display: flex;
    width: 100%;
    height: 100%;
    z-index: 999;
    justify-content: center;
    align-items: center;
}
</style>
