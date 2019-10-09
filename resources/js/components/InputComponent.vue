<template>
  <div>
    <template v-if="inputType == 'default'">
      <input
        :value="value"
        :type="type"
        :class="computedClass"
        :disabled="disabled"
        :placeholder="placeholder"
        :required="required"
        :autocomplete="type=='password' ? 'new-password' : 'false'"
        @input="onInput($event.target.value)"
        @blur="onBlur($event)"
      />
      <div class="col-12 invalid-feedback" v-if="error">
        {{ error }}
      </div>
    </template>
    <dropdown-component v-if="inputType == 'dropdown'"
      :value="value"
      :css-class="computedClass"
      :relation="relation"
      :displayColumn="relationDisplay"
      :placeholder="placeholder"
      :required="required"
      :error="error"
      :options="options"
      @input="onInput($event)"
      @blur="onBlur($event)"
    />
    <autocomplete-component v-if="inputType == 'autocomplete'"
      :value="value"
      :css-class="computedClass"
      :relation="relation"
      :displayColumn="relationDisplay"
      :placeholder="placeholder"
      :required="required"
      :error="error"
      @input="onInput($event)"
      @blur="onBlur($event)"
    />
    <file-component v-if="inputType == 'file'"
      :value="value"
      :css-class="computedClass"
      :error="error"
      @input="onInput($event)"
      @blur="onBlur($event)"
    />
  </div>
</template>

<script>
  export default {
    props: {
      value: { type: [String, Object, Number], default: '' },
      type: { type: String, default: 'text' },
      relation: { type: String, default: null },
      relationDisplay: { type: String, default: null },
      cssClass: { type: String, default: null },
      disabled: { type: Boolean, default: false },
      placeholder: { type: String, default: '' },
      required: { type: Boolean, default: false },
      error: { type: String, default: null },
      options: { type: Array, default: null },
    },
    computed: {
      computedClass () {
        return `${this.cssClass} ${this.error ? 'is-invalid' : ''}`
      },
      inputType () {
        if (!_.isNil(this.relation)) return 'autocomplete'
        if (this.type == 'file') return 'file'
        if (this.type == 'dropdown') return 'dropdown'

        return 'default'
      },
    },
    methods: {
      onInput(event) {
        this.$emit('input', event)
      },
      onBlur(event) {
        const newValue = _.get(event, 'srcElement')
          ? event.target.value
          :event
        this.$emit('blur', newValue)
      }
    }
  }
</script>

<style scoped>
  >>> ::placeholder {
    color: #cacaca !important;
  }
</style>
