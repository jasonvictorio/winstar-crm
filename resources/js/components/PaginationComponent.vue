<template>
  <div>
    <ul class="pagination">
      <li class="paginate_button page-item previous">
        <button class="page-link" @click="paginate(pagination.current-1)" :disabled="this.pagination.current == 1">Previous</button>
      </li>
      <li v-for="page in pages" :key="page" class="paginate_button page-item" :class="{ active: page == pagination.current }">
        <button class="page-link" @click="paginate(page)">{{ page }}</button>
      </li>
      <li class="paginate_button page-item next">
        <button class="page-link" @click="paginate(pagination.current+1)" :disabled="disableNext">Next</button>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    props: {
      pagination: {
        type: Object,
        default: {
          current: 1,
          total: 1,
          limit: 1,
        },
      },
    },
    computed: {
      pages () {
        let pages = []
        const lastPage = Math.round(this.pagination.total / this.pagination.limit)
        for (let index = 0; index < lastPage; index++) {
          pages[index] = index + 1
        }
        return pages
      },
      disableNext () {
        const lastPage = Math.round(this.pagination.total / this.pagination.limit)
        const currentPage = this.pagination.current
        return currentPage == lastPage
      },
    },
    methods: {
      paginate: function (page) {
        this.$emit('paginate', page)
      }
    }
  }
</script>

<style scoped>

</style>
