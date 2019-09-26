<template>
  <div class="table-responsive card card-body">
    <div class="d-flex align-items-center justify-content-between">
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
      @editData="modalSetData"
      @deleteData="deleteData"
      @inlineEdit="inlineEdit"
    />
    <pagination-component class="mt-3"
      :from="pagination.from"
      :to="pagination.to"
      :total="pagination.total"
      :perPage="pagination.perPage"
      :currentPage="pagination.currentPage"
      :lastPage="pagination.lastPage"
      @paginate="fetchData"
      @limitChange="onLimitChange"
    />
    <modal-component
      :data="modalData"
      :fields="modalFields"
      :title="modalTitle"
      :visible="modalVisible"
      :error="error"
      @hideModal="modalHide"
      @save="modalSave"
    />
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
      error: null,
      pagination: {
        currentPage: 1,
        lastPage: 1,
        from: 1,
        to: 1,
        total: 1,
        perPage: 10,
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
      addNewFields () {
        return this.computedColumns.filter(column => column.editable || (!column.editable && column.hide))
      },
      modalFields () {
        return _.isNil(_.get(this.modalData, 'id'))
          ? this.addNewFields
          : this.editableFields
      },
      headers () {
        const sortBy = this.sortBy.relation
          ? `${this.sortBy.property}_id`
          : this.sortBy.property
        return {
          sortBy: sortBy,
          sortOrder: this.sortOrder,
          perPage: this.pagination.perPage,
        }
      },
    },
    mounted () {
      this.fetchData();
    },
    methods: {
      async fetchData(page = 1) {
        const response = await axios.get(`${this.apiRoute}?page=${page}`, {
          headers: this.headers
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
          required: true,
        }, column)
      },
      refreshData () {
        this.fetchData(this.pagination.currentPage)
      },
      modalSetData (data) {
        this.clearError()
        this.modalData = _.cloneDeep(data)
        this.setModalTitle(data)
        this.showModal()
      },
      showModal () {
        this.modalVisible = true
      },
      modalHide () {
        this.modalVisible = false
        this.clearError()
      },
      async modalSave (data) {
        // const data = _.pickBy(modalData, !_.isEmpty)
        try {
          const responseData = await this.saveData(data)
          this.notificationSuccess('Update saved')
          this.refreshData()
          this.modalSetData(data)
        } catch (error) {
          this.error = error
        }
      },
      clearError () {
        this.error = null
      },
      setModalTitle (data) {
        this.modalTitle = _.isNil(data.id)
          ? `Create New`
          : `${data.id} - ${data[this.displayProperty]}`
      },
      async saveData(data) {
        const isNewData = _.isNil(data.id)
        try {
          const response = isNewData
            ? await axios.post(`${this.apiRoute}`, data)
            : await axios.put(`${this.apiRoute}/${data.id}`, data)
          return response.data
        } catch (error) {
          throw this.formatError(error.response.data)
        }
      },
      formatError (error) {
        return _.mapKeys(error, (value, key) => {
          return _.endsWith(key, '_id')
            ? _.replace(key, '_id', '')
            : key
        })
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
        this.modalSetData(data)
      },
      updatePagination (response) {
        this.pagination = {
          currentPage: response.current_page,
          lastPage: response.last_page,
          from: response.from,
          to: response.to,
          total: response.total,
          perPage: Number(response.per_page),
        }
      },
      notificationSuccess (message) {
        Vue.$toast.open({
          message: message,
          position: 'top-right',
          type: 'success',
        })
      },
      onLimitChange(limit) {
        this.pagination.perPage = limit
        this.fetchData(1)
      }
    },
  }
</script>
