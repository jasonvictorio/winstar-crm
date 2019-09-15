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
              <form @submit.prevent="save">
                <div class="form-group row" v-for="field in fields" :key="field.property">
                  <label for="inputEmail3" class="col-sm-3 col-form-label">{{ field.label }}</label>
                  <div class="col-sm-9">
                    <input v-if="!field.relation" v-model="data[field.property]" :type="field.type" class="form-control" :placeholder="field.placeholder">
                    <autocomplete-component v-model="data[field.property]"  v-if="field.relation" css-class="form-control" :placeholder="field.placeholder" :name="field.property" :relation="field.relation" :displayColumn="field.relationDisplay"/>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" @click="save">Save</button>
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
    },
    computed: {

    },
    methods: {
      close () {
        this.$emit('hideModal')
      },
      save () {
        this.$emit('save', this.data)
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
