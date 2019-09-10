<template>
  <div class="table-responsive card card-body">
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
            <button v-if="editable" class="btn btn-primary" @click="editData(data)"><i class="far fa-edit"></i></button>
            <button v-if="deleteable" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
          </td>
        </tr>
      </tbody>
    </table>

    <pagination-component class="mt-3" :pagination="pagination" @paginate="fetchData"/>
    <modal-component :visible="modalVisible" @hideModal="hideModal" :title="modalTitle" />
  </div>
</template>

<script>
  export default {
    props: {
      apiEndpoint: String,
      columns: Array,
      displayProperty: String,
      editable: { type: Boolean, default: true },
      deleteable: { type: Boolean, default: true },
    },
    data: () => ({
      data: [],
      modalTitle: '',
      modalVisible: false,
      pagination: {
        total: 0,
        current: 1,
        limit: 15,
      },
    }),
    mounted () {
      this.fetchData();
    },
    methods: {
      async fetchData(page = 1) {
        const response = await axios.get(`/api/${this.apiEndpoint}?page=${page}`)
        this.data = response.data.data
        this.updatePagination(response.data)
      },
      editData (data) {
        this.modalTitle = this.getProperty(data, this.displayProperty)
        this.showModal()
      },
      showModal () {
        this.modalVisible = true
      },
      hideModal () {
        this.modalVisible = false
      },
      getProperty (data, property) {
        return _.get(data, property)
      },
      updatePagination (response) {
        this.pagination = {
          total: response.total,
          current: response.current_page,
          limit: response.per_page,
        }
      },
    },
  }
</script>

<style scoped>
</style>
