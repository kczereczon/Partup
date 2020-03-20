<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="mt-auto mb-auto col-6">Groups</div>
                            <div class="col-6 text-right">
                                <a class>
                                    <span class="fa fa-plus"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <group-component
                            v-for="group in groups"
                            :key="group.id"
                            :id="group.id"
                            :name="group.name"
                            :subgroups="group.subgroups"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            groups: [
                {
                    id: 1,
                    name: "Informatyk - 4 semestr",
                    subgroups: [
                        {
                            id: 2,
                            name: "Grupa 1",
                            subgroups: [
                                {
                                    id: 3,
                                    name: "Lab 1",
                                    subgroups: []
                                },
                                {
                                    id: 4,
                                    name: "Lab 2",
                                    subgroups: []
                                }
                            ]
                        },
                        {
                            id: 5,
                            name: "Grupa 2",
                            subgroups: [
                                {
                                    id: 6,
                                    name: "Lab 3",
                                    subgroups: []
                                },
                                {
                                    id: 7,
                                    name: "Lab 4",
                                    subgroups: []
                                }
                            ]
                        }
                    ]
                }
            ]
        };
    }
};
</script>

<style>
</style>
