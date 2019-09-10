<template>
  <div class="table-responsive card card-body">
    <!-- <pagination-component /> -->
    <table class="table table-hover">
      <thead>
        <tr>
          <th v-for="column in columns" :key="column.property">
            {{ column.label }}
          </th>
          <th v-if="editable || deleteable">
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="data in data" :key="data.id">
          <td v-for="column in columns" :key="column.property">
            {{ getProperty(data, column.property) }}
          </td>
          <td v-if="editable || deleteable">
            <button v-if="editable" class="btn btn-primary"><i class="far fa-edit"></i></button>
            <button v-if="deleteable" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    props: {
      apiEndpoint: String,
      columns: Array,
      editable: { type: Boolean, default: true },
      deleteable: { type: Boolean, default: true },
    },
    data: () => ({
      data: [],
    }),
    mounted () {
      this.fetchData();
    },
    methods: {
      async fetchData() {
        const response = await axios.get(`/api/${this.apiEndpoint}`)
        this.data = response.data.data
      },
      getProperty (data, property) {
        return _.get(data, property)
      },
    },
  }
</script>

<style scoped>
</style>
