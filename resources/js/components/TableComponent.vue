<template>
  <div class="table-responsive card card-body">
    <div class="d-flex align-items-center justify-content-between">
      <pagination-component class="mt-3" :pagination="pagination" @paginate="fetchData"/>
      <button class="btn btn-primary" @click="addNew()"><i class="fa fa-plus"></i> Add new item</button>
    </div>
    <table class="table table-hover">
      <thead>
        <tr>
          <th v-for="column in displayColumns" :key="column.property">
            {{ column.label }}
          </th>
          <th v-if="editable || deleteable">
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="data in data" :key="data.id">
          <td v-for="column in displayColumns" :key="column.property">
            <input v-if="!column.relation" type="text" @blur="onInputBlur($event.target.value, data, column)" class="form-control" :value="data[column.property]" :disabled="!column.editable">
            <autocomplete-component :value="clone(data[column.property])" @blur="(newValue) => onInputBlur(newValue, data, column)"  v-if="column.relation" css-class="form-control" name="company" :relation="column.relation" :displayColumn="column.relationDisplay"/>
          </td>
          <td v-if="editable || deleteable">
            <button v-if="editable" class="btn btn-primary" @click="editData(data)"><i class="far fa-edit"></i></button>
            <button v-if="deleteable" class="btn btn-outline-danger" @click="deleteData(data)"><i class="far fa-trash-alt"></i></button>
          </td>
        </tr>
      </tbody>
    </table>

    <pagination-component class="mt-3" :pagination="pagination" @paginate="fetchData"/>
    <modal-component :visible="modalVisible" @hideModal="hideModal" @save="saveData" :title="modalTitle" :fields="editableFields" :data="modalData" />
  </div>
</template>

<script>
  export default {
    props: {
      apiEndpoint: String,
      columns: Array,
      editable: Array,
      displayProperty: String,
      allowNew: { type: Boolean, default: true },
      editable: { type: Boolean, default: true },
      deleteable: { type: Boolean, default: true },
      showUpdatedAt: { type: Boolean, default: false },
      showCreatedAt: { type: Boolean, default: false },
    },
    data: () => ({
      data: [],
      modalTitle: '',
      modalVisible: false,
      modalData: null,
      pagination: {
        total: 0,
        current: 1,
        limit: 15,
      },
    }),
    computed: {
      apiRoute () {
        return `/api/${this.apiEndpoint}`
      },
      computedColumns () {
        let columns = [{ property: 'id', label: 'ID', editable: false }, ...this.columns]
        if (this.showCreatedAt) columns.push({ property: 'created_at', label: 'Date created', editable: false })
        if (this.showUpdatedAt) columns.push({ property: 'updated_at', label: 'Date updated', editable: false })
        return columns.map(this.assignColumnDefaults)
      },
      displayColumns () {
        return this.computedColumns.filter(column => !column.hide)
      },
      editableFields () {
        return this.computedColumns.filter(column => column.editable)
      },
    },
    mounted () {
      this.fetchData();
    },
    methods: {
      async fetchData(page = 1) {
        const response = await axios.get(`${this.apiRoute}?page=${page}`)
        this.data = response.data.data
        this.updatePagination(response.data)
      },
      clone(data) {
        return _.clone(data)
      },
      onInputBlur(newValue, data, column) {
        const oldValue = data[column.property]
        if (_.isEqual(newValue, oldValue)) return

        const updatedData = _.merge(data, {
          [column.property]: newValue
        })
        this.saveData(updatedData)
      },
      assignColumnDefaults (column) {
        return _.assign({
          editable: true,
          placeholder: column.label,
          type: 'text',
          hide: false,
        }, column)
      },
      refreshData () {
        this.fetchData(this.pagination.current)
      },
      editData (data) {
        this.modalData = _.cloneDeep(data)
        this.setModalTitle(data)
        this.showModal()
      },
      showModal () {
        this.modalVisible = true
      },
      hideModal () {
        this.modalVisible = false
      },
      setModalTitle (data) {
        this.modalTitle = _.isNil(data.id)
          ? `Create New`
          : `${data.id} - ${data[this.displayProperty]}`
      },
      async saveData(data) {
        const isNewData = _.isNil(data.id)
        const response = isNewData
          ? await axios.post(`${this.apiRoute}`, data)
          : await axios.put(`${this.apiRoute}/${data.id}`, data)

        this.setModalTitle(data)
        this.refreshData()
        this.notificationSuccess('Update saved')
      },
      deleteData(data) {
        axios.delete(`${this.apiRoute}/${data.id}`)
          .then(response => {
            this.refreshData()
            this.notificationSuccess('Delete success')
          })
      },
      addNew () {
        const data = {}
        this.editableFields.forEach(field => {
          data[field.property] = null
        });
        this.editData(data)
      },
      updatePagination (response) {
        this.pagination = {
          total: response.total,
          current: response.current_page,
          limit: response.per_page,
        }
      },
      formatDate (date) {
        return
      },
      notificationSuccess (message) {
        Vue.$toast.open({
          message: message,
          position: 'top-right',
          type: 'success',
        })
      },
    },
  }
</script>

<style scoped>
  table >>> input {
    width: 100%;
    border: 0;
    background-color: transparent;
    margin-left: -13px;
    border: 1px solid transparent;
  }

  table >>> input:disabled {
    background-color: transparent;
  }

  table >>> input:focus {
    border-color: #a1cbef;
  }

  table >>> input:read-only {
    background: transparent;
  }

  table >>> .form-control:focus {
    background-color: #fff;
  }
</style>
