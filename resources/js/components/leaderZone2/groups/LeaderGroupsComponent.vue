<template>
    <div class="row">
        <div class="col">
            <button
                type="button"
                class="btn btn-link bg-light px-4 my-2 mx-3"
                style="border:1px solid rgba(0, 0, 0, 0.125)"
                v-on:click="redirectToGroup(group.id)"
            >
                <h5 class="my-0">{{group.name}}</h5>
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: ["group"],
    data() {
        return {
            group: this.group,
            showContent: true
        };
    },
    methods: {
        redirectToGroup(idGrupy) {
            this.$router.push({ name: "GroupView", params: { id: idGrupy } });
        },
        changeDisplayShowContent() {
            this.showContent = !this.showContent;
        }
    }
};
</script>

<style></style>
