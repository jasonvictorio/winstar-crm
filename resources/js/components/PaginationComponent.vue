<template>
  <div class="d-flex align-items-center">
    <ul class="pagination mb-0 mr-3">
      <li class="paginate_button page-item previous" :class="{ disabled: currentPage == 1 }">
        <button class="page-link" @click="paginate(currentPage-1)">Previous</button>
      </li>
      <li v-for="page in pages" :key="page" class="paginate_button page-item" :class="{ active: page == currentPage }">
        <button class="page-link" @click="paginate(page)">{{ page }}</button>
      </li>
      <li class="paginate_button page-item next" :class="{ disabled: currentPage == lastPage}">
        <button class="page-link" @click="paginate(currentPage+1)">Next</button>
      </li>
    </ul>
    <span>{{ display }}</span>
    <div class="d-flex align-items-center ml-auto">
      <p class="mb-0 mr-2">Show</p>
      <select class="custom-select custom-select-sm" value="perPage" @change="onLimitChange($event)">
        <option v-for="limit in limits" :value="limit" :key="limit">{{limit}}</option>
      </select>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      currentPage: { type: Number, default: 1 },
      lastPage: { type: Number, default: 1 },
      from: { type: Number, default: 1 },
      to: { type: Number, default: 1 },
      total: { type: Number, default: 1 },
      perPage: { type: Number, default: 10 },
    },
    data: () => ({
      limits: [10, 20, 40, 80],
    }),
    computed: {
      pages () {
        return _.range(1, this.lastPage+1)
      },
      display () {
        return `Showing ${this.from} to ${this.to} of ${this.total} entries`
      },
    },
    methods: {
      paginate: function (page) {
        this.$emit('paginate', page)
      },
      onLimitChange(event) {
        this.$emit('limitChange', Number(event.target.value))
      }
    },
  }
</script>
