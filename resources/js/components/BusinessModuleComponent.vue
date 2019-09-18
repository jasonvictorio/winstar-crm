<template>
  <div class="table-responsive card card-body">
    <div class="d-flex align-items-center justify-content-between">
      <pagination-component class="mt-3" :pagination="pagination" @paginate="fetchData"/>
      <button class="btn btn-primary" @click="addNew()"><i class="fa fa-plus"></i> Add new item</button>
    </div>
    <table-component
      :data="data"
      :columns="displayColumns"
      :sortBy="sortBy"
      :sortOrder="sortOrder"
      :editable="editable"
      :deleteable="deleteable"
      :showUpdatedAt="showUpdatedAt"
      :showCreatedAt="showCreatedAt"
      @sort="sort"
      @editData="editData"
      @deleteData="deleteData"
      @inlineEdit="inlineEdit"
    />
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
      sortBy: { property: 'id' },
      sortOrder: 'asc',
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
        return this.computedColumns.filter(column => column.editable || (!column.editable && column.hide))
      },
      sortHeaders () {
        const sortBy = this.sortBy.relation
          ? `${this.sortBy.property}_id`
          : this.sortBy.property
        return {
          sortBy: sortBy,
          sortOrder: this.sortOrder,
        }
      },
    },
    mounted () {
      this.fetchData();
    },
    methods: {
      async fetchData(page = 1) {
        const response = await axios.get(`${this.apiRoute}?page=${page}`, {
          headers: this.sortHeaders
        })
        this.data = response.data.data
        this.updatePagination(response.data)
      },
      sort(sortBy, sortOrder) {
        this.sortBy = sortBy
        this.sortOrder = sortOrder
        this.refreshData()
      },
      inlineEdit(newValue, data, column) {
        const oldValue = data[column.property]
        if (_.isEqual(newValue, oldValue)) return

        const updatedData = _.merge(data, {
          [column.property]: newValue
        })
        this.saveData(updatedData)
      },
      assignColumnDefaults (column) {
        return _.assign({
          label: _.startCase(column.property),
          placeholder: column.label || _.startCase(column.property),
          type: 'text',
          editable: true,
          hide: false,
          sort: true,
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
