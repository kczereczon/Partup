<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <button type="button" class="btn">{{group.name}}</button>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row text-right">
                        <div class="col">
                            <span class="fa fa-caret-down"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <button
                type="button"
                class="btn py-2 bg-primary"
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
    props: ["group"],
    data() {
        return {
            group: this.group
        };
    },
    methods:{
        redirectToGroup(idGrupy){
            this.$router.push({name: 'GroupView', params: { id: idGrupy }});
        }
    }
};
</script>

<style></style>
