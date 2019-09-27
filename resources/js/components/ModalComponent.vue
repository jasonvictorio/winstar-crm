<template>
  <div>
    <transition-group name="fade">
      <div :key="'backdrop'" v-if="visible" class="modal-backdrop"></div>
      <div :key="'modal'" v-if="visible" class="modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div class="modal-title" id="exampleModalLabel">{{ title }}</div>
              <button type="button" class="close" @click="close">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="save" novalidate>
                <div class="form-group row" v-for="field in fields" :key="field.property">
                  <label for="inputEmail3" class="col-sm-3 col-form-label">{{ field.label }}</label>
                  <div class="col-sm-9">
                    <input-component v-model="data[field.property]"
                      :type="field.type"
                      css-class="form-control"
                      :relation="field.relation"
                      :relationDisplay="field.relationDisplay"
                      :placeholder="field.placeholder"
                      :required="field.required"
                      :error="head(get(errorLocal, field.property))"
                      @input="inputChange(field.property)"
                    />
                  </div>
                </div>
                <button class="btn btn-success d-block ml-auto" type="submit">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<script>
  export default {
    props: {
      visible: Boolean,
      title: String,
      fields: Array,
      data: Object,
      error: { type: Object, default: null }
    },
    computed: {
      requiredFields () {
        return this.fields.filter(field => field.required)
      },
    },
    data: () => ({
      errorLocal: null,
    }),
    watch: {
      error: function(error) { // watch it
        this.errorLocal = error
      },
    },
    methods: {
      get (object, property) {
        return _.get(object, property)
      },
      head (array) {
        return _.head (array)
      },
      close () {
        this.$emit('hideModal')
      },
      save () {
        this.$emit('save', this.data)
      },
      inputChange (inputProperty) {
        this.errorLocal = _.omit(this.errorLocal, inputProperty)
      },
    }
  }
</script>

<style scoped>
  .modal-backdrop {
    background-color: rgba(0,0,0, 0.5);
  }

  .modal {
    display: block;
  }

  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }
</style>
