<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <button type="button" class="btn">{{group.name}} |</button>
                        <leader-groups-header
                            v-for="(group2) in group.subgroups"
                            :group="group2"
                            :key="'s'+group2.id"
                            :current="current"
                        />
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
            <div
                v-for="(group3) in current.subgroups"
                :group="group3"
                :key="'s'+group3.id+'d'"
            >
            <button type="button" class="btn btn-primary"
                v-on:click="changeCurrent(group3)"
            >
                {{group3.name}}
            </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["group"],
    data() {
        return {
            group: this.group,
            current: this.group
        };
    },
    methods:{
        changeCurrent(group){
            this.current=group;
        }
    }
};
</script>

<style></style>
