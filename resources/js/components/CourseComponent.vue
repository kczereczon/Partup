<template>
    <div class="card">
        <div class="card-body bg-light">
            <div class="row no-gutters">
                <div class="col-4 mt-auto mb-auto">
                    <h1 v-if="!editMode">{{ name }}</h1>
                    <input
                        v-if="editMode"
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Course name."
                        v-model="newName"
                    />
                </div>
                <div class="col-6 mt-auto mb-auto">
                    <h1 v-if="!editMode">{{ group.name || "" }}</h1>
                    <select
                        v-if="editMode"
                        type="text"
                        name="name"
                        class="form-control ml-auto mr-auto w-75"
                        placeholder="Course name."
                        v-model="newGroupId"
                    >
                        <option
                            v-for="optionGroup in groups"
                            :key="optionGroup.id"
                            :value="optionGroup.id"
                            :selected="optionGroup.id == group.id"
                            >{{ optionGroup.name }}</option
                        >
                    </select>
                </div>
                <div class="col-2 mt-auto mb-auto  text-right">
                    <a v-on:click="close()" class="ml-1">
                        <span
                            :class="[
                                'fa',
                                { 'fa-minus': !editMode, 'fa-times': editMode }
                            ]"
                        ></span>
                    </a>
                    <a v-on:click="editMode ? save() : edit()" class="ml-1">
                        <span
                            :class="{
                                'fa fa-pen': !editMode,
                                'fa fa-save': editMode
                            }"
                        ></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["id", "name", "groups", "group"],
    edit() {
        this.editMode = true;
    },
    save() {
        this.editMode = false;
    },
    close() {
        this.editMode = false;
    },
    data() {
        return {
            editMode: this.$vnode.key == 0 && !this.id ? true : false,
            newName: this.name,
            newGroupId: this.group.id || ""
        };
    }
};
</script>

<style></style>
