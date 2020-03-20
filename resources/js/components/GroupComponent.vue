<template>
    <div class="card">
        <div class="card-body bg-light">
            <div class="row no-gutters">
                <div class="col-6 mt-auto mb-auto">
                    <h5 v-if="!editMode" class="mb-0">{{name}}</h5>
                    <input
                        v-model="name"
                        v-if="editMode"
                        class="form-control"
                        ref="input"
                        type="text"
                    />
                </div>
                <div class="col-6 mt-auto mb-auto text-right">
                    <div class="row">
                        <div class="col">
                            <a
                                v-if="!editMode && subgroups.length"
                                v-on:click="shouldShowSubgroups = !shouldShowSubgroups"
                                class="ml-1"
                            >
                                <span
                                    :class="{'fa fa-caret-down': !shouldShowSubgroups, 'fa fa-caret-up': shouldShowSubgroups}"
                                ></span>
                            </a>
                            <a v-if="!editMode" class="ml-1">
                                <span class="fa fa-plus"></span>
                            </a>
                            <a v-if="!editMode" class="ml-1">
                                <span class="fa fa-minus"></span>
                            </a>
                            <a v-on:click="editMode = !editMode" class="ml-1">
                                <span :class="{'fa fa-pen': !editMode, 'fa fa-save': editMode}"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul v-if="shouldShowSubgroups" class="list-group list-group-flush">
            <li
                v-for="(group, index) in subgroups"
                :key="group.id"
                :class="[{'border-top': index==0}, 'list-group-item']"
            >
                <group-component :id="group.id" :name="group.name" :subgroups="group.subgroups" />
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ["id", "name", "subgroups", "editMode"],
    data() {
        return {
            shouldShowSubgroups: false
        };
    },
    methods: {
        edit() {
            this.editMode = true;
        },
        save() {
            this.editMode = false;
        },
        showSubgroups() {
            this.shouldShowSubgroups = true;
        }
    }
};
</script>

<style lang="sass">
</style>
