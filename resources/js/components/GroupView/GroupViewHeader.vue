<template>
    <span>
        <!-- <span v-if="!!group.group">
            <group-view-header
                v-for="(group2) in group.group"
                :group="group2"
                :key="'s'+group2.id"
            />
        </span> -->
        <button type="button" class="btn bg-danger" v-on:click="redirectToGroup(group.group.id)">
            {{group.name}} das
        </button>
    </span>
</template>
<script>
export default {
    props: ["group"],
    data() {
        return {
            group:[],
        };
    },
    methods: {
        redirectToGroup(idGrupy){
            this.$router.push({name: 'GroupView', params: { id: idGrupy }});
            this.$emit("refresh");
        }
    }
};
</script>
<style></style>
