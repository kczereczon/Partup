<template>
    <div class="row justify-content-center">
        <div class="col-md-11 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="mt-auto mb-auto col-6">Groups</div>
                        <div class="col-6 text-right">
                            <a v-on:click="addNewGroup()" class>
                                <span class="fa fa-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <leader-groups-component
                        v-for="(group) in groups"
                        :group="group"
                        :key="group.id+'group'"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["groups"],
    data() {
        return {
            groups: this.groups
        };
    }
};
</script>

<style></style>
