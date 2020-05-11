<template>
<span>
        <button type="button" class="btn" v-if="group.id==current.id">
            {{group.name}} |
        </button>
        <leader-groups-header
            v-for="(group2) in group.subgroups"
            :group="group2"
            :key="'s'+group2.id"
            :current="current"
        />
</span>
</template>
<script>
export default {
    props: ["group","current"],
    data() {
        return {
            group: this.group,
            current: this.current,
        };
    }
};
</script>

<style></style>
