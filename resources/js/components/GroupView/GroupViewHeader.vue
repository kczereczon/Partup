<template>
  <nav aria-label="breadcrumb" class="h-100">
    <ol class="breadcrumb h-100">
       <li v-for="parent in flat" :key="parent.id" :class="['breadcrumb-item', {'active': parent.active}]">
           <a v-if="!parent.active" @click="redirectToGroup(parent.id, $event)" href="#">{{parent.name}}</a>
           <span v-if="parent.active">{{parent.name}}</span>
        </li>
    </ol>
  </nav>
</template>
<script>
export default {
  props: ["group"],
  data() {
      return {
          flat: []
      }
  },
  created() {
    this.group.active = true;
    this.flatten(this.$props.group)
    this.flat.reverse();
  },
  methods: {
    redirectToGroup(idGrupy, event) {
        event.preventDefault();
      this.$router.push({ name: "GroupView", params: { id: idGrupy } });
      this.$emit("refresh");
    },
    flatten(el) {
      this.flat.push(el);
      if (el.group) {
        this.flatten(el.group);
      }
    }
  }
};
</script>
<style></style>
