<template>
  <div>
    <input v-if="!relation"
      :value="value"
      :type="type"
      :class="cssClass"
      :disabled="disabled"
      :placeholder="placeholder"
      @input="onInput($event.target.value)"
      @blur="onBlur($event)"
    />
    <autocomplete-component v-if="relation"
      :value="value"
      :css-class="cssClass"
      :relation="relation"
      :displayColumn="relationDisplay"
      :placeholder="placeholder"
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
    },
    computed: {

    },
    methods: {
      onInput(event) {
        this.$emit('input', event)
      },
      onBlur(event) {
        const newValue = event.srcElement
          ? event.target.value
          :event
        this.$emit('blur', newValue)
      }
    }
  }
</script>
