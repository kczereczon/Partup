<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item">
        <a class="page-link" @click="getPaginate(1, $event)" href="#">First page</a>
      </li>
      <li
        v-for="n in getItems()"
        :key="n"
        :class="{'page-item': true, 'active': n == currentPage}"
      >
        <a
          class="page-link"
          href="#"
          @click="getPaginate(n, $event)"
        >{{n}}</a>
      </li>
      <li class="page-item">
        <a class="page-link" @click="getPaginate(pagesCount, $event)" href="#">Last Page</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: ["total", "path", "lastPage", "firstPage", "currentPage", "perPage"],
  data() {
    return {
      pagesCount:
        this.$props.total != 0
          ? Math.ceil(this.$props.total / this.$props.perPage)
          : 0
    };
  },
  methods: {
    getPaginate(page, event) {
      event.preventDefault();
      this.$emit("getPaginate", page);
    },
    getItems() {
        let array = [];

        for (let n = this.$props.currentPage-1; n < (this.pagesCount-this.$props.currentPage >= 1 ? this.$props.currentPage+2 : this.$props.currentPage+1); n++) {
            if(this.$props.currentPage == 1) {
                array.push(n+1);
            } else {
                array.push(n);
            }
        }

        return array;
    }
  }
};
</script>

<style>
</style>
