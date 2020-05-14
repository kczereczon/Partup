<template>
    <div class="card">
        <div class="card-header p-0">
            <!-- <button
                type="button"
                class="btn my-2 mx-2 bg-primary"
                v-on:click="redirectToGroup(group.id)"
            >
            {{group.name}}
            </button> -->
            <group-view-header
                :group="group"
                :key="'h'+group.id"
                @refresh="getGroup()"
            />
        </div>
        <div class="card-body">
            <button
                type="button"
                class="btn my-2 mx-2 w-25 bg-primary"
                v-for="(groups) in group.subgroups"
                :key="'g'+groups.id"
                v-on:click="redirectToGroup(groups.id)"
            >
            {{groups.name}}
            </button>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            group:[],
        };
    },
    mounted() {
        this.getGroup();
    },
    methods: {
        getGroup() {
            if(JSON.parse(window.sessionStorage.leaderGroups)[this.$route.params.id])
                this.group = JSON.parse(window.sessionStorage.leaderGroups)[this.$route.params.id];
            else
                this.$router.push({name: 'LeaderZone'});
        },
        redirectToGroup(idGrupy){
            this.$router.push({name: 'GroupView', params: { id: idGrupy }});
            this.getGroup();
        }
    }
};
</script>
<style></style>
