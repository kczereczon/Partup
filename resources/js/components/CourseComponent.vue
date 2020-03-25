<template>
    <div class="card">
        <div class="card-body bg-light">
            <div class="row no-gutters">
                <div class="col-4 mt-auto mb-auto">
                    <h5 class="mb-0" v-if="!editMode">{{ name || "" }}</h5>
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
                    <h5 class="mb-0" v-if="!editMode">
                        {{ group.full_name || "" }}
                    </h5>
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
                            >{{ optionGroup.full_name }}</option
                        >
                    </select>
                </div>
                <div class="col-2 mt-auto mb-auto text-right">
                    <a v-if="editMode" class="ml-1">
                        <span class="fa fa-user-add"></span>
                    </a>
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
    props: ["id", "name", "groups", "group", "new"],
    created() {
        console.log(this.new);
    },
    methods: {
        save() {
            if(!this.id)
            {
                this.$http
                    .post("/v1/course", {
                        name: this.newName,
                        group_id: this.newGroupId
                    }
                    )
                    .then(result => {
                        this.editMode = false;
                        this.refreshCourses();
                    })
                    .catch(err => {});
            }else{
                this.$http
                    .patch(
                        "/v1/course/"+this.id,
                        {
                            name:this.newName,
                            group_id: this.newGroupId
                        }
                    )
                    .then(result=>{
                        this.editMode = false;
                        this.refreshCourses();
                    })
                    .catch(error =>{
                        this.error = error.response.data.errors;
                    });
            }

        },
        close() {
            if (!this.editMode) {
                if (confirm("Are you sure, you want remove this course?"))
                    this.$http
                        .delete("/v1/course/" + this.id)
                        .then(result => {
                            this.removeCourseFromArray();
                            this.refreshCourses();
                        })
                        .catch(err => {});
            } else {
                if (this.id) {
                    this.editMode = false;
                } else {
                    this.removeCourseFromArray();
                }
            }
        },
        edit() {
            this.editMode = true;
        },
        refreshCourses() {
            this.$emit("refresh");
        },
        removeCourseFromArray() {
            this.$emit("removeCourseFromArray", this.id);
        }
    },
    data() {
        return {
            editMode: this.new,
            newName: this.name,
            newGroupId: this.group.id || ""
        };
    }
};
</script>

<style></style>
