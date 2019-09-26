<template>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="customFile" @change="fileChange($event)">
      <label class="custom-file-label" for="customFile">{{ title }}</label>
    </div>
</template>

<script>
  export default {
    props: {
      value: { type: [String, Object, Number], default: '' },
      cssClass: { type: String, default: null },
      placeholder: { type: String, default: '' },
      required: { type: Boolean, default: false },
      error: { type: String, default: null },
    },
    computed: {
      title () {
        return this.value
          ? 'File selected'
          : 'Choose File'
      }
    },
    methods: {
      async fileChange (event) {
        const file = _.head(event.target.files)
        const base64File = await this.toBase64(file)
        this.$emit('input', base64File)
      },
      toBase64 (file) {
        return new Promise((resolve, reject) => {
          const reader = new FileReader()
          reader.readAsDataURL(file)
          reader.onload = () => resolve(reader.result)
          reader.onerror = error => reject(error)
        })
      },
    },
  }
</script>
