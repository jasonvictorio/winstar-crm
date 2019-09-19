<template>
  <table class="table table-hover">
    <thead>
      <tr>
        <th v-for="column in columns" :key="column.property">
          <div class="d-flex align-items-center">
            <span>{{ column.label }}</span>
            <div class="ml-auto sort" :class="{ active: sortBy.property == column.property }" v-if="column.sort">
              <button class="btn btn-sm sort-button active" @click="sort(column)">
                <template v-if="sortBy.property == column.property">
                  <i class="fa fa-sort-up" v-if="sortOrder == 'asc'" ></i>
                  <i class="fa fa-sort-down" v-if="sortOrder == 'desc'" ></i>
                </template>
                <i class="fa fa-sort" v-if="sortBy.property != column.property"></i>
              </button>
              <!-- <button class="btn btn-sm sort-button" @click="$emit('sort', column, 'desc')" :class="{ active: sortOrder == 'desc' }">
                <i class="fa fa-arrow-down"></i>
              </button> -->
            </div>
          </div>
        </th>
        <th v-if="editable || deleteable">
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="data in data" :key="data.id">
        <td v-for="column in columns" :key="column.property">
          <input-component :value="clone(data[column.property])"
            @blur="(newValue) => $emit('inlineEdit', newValue, data, column)"
            :type="column.type"
            :disabled="!column.editable"
            css-class="form-control"
            :relation="column.relation"
            :relationDisplay="column.relationDisplay"
          />
        </td>
        <td v-if="editable || deleteable">
          <button v-if="editable" class="btn btn-primary" @click="$emit('editData', data)"><i class="far fa-edit"></i></button>
          <button v-if="deleteable" class="btn btn-outline-danger" @click="$emit('deleteData', data)"><i class="far fa-trash-alt"></i></button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
  export default {
    props: {
      data: Array,
      columns: Array,
      sortBy: { type: Object, default: { property: 'id' } },
      sortOrder: { type: String, default: 'asc' },
      editable: { type: Boolean, default: true },
      deleteable: { type: Boolean, default: true },
      showUpdatedAt: { type: Boolean, default: false },
      showCreatedAt: { type: Boolean, default: false },
    },
    methods: {
      clone(data) {
        return _.clone(data)
      },
      sort(column) {
        const sortOrder = column.property == this.sortBy.property
          ? (this.sortOrder == 'asc' ? 'desc' : 'asc')
          : 'asc'
        this.$emit('sort', column, sortOrder)
      }
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

  .sort-button {
    opacity: 0.2;
    padding: 0;
    transition: opacity 200ms ease-in-out;
  }

  .sort-button:hover {
    opacity: 0.5;
  }

  .sort.active .sort-button.active {
    opacity: 1;
  }
</style>
