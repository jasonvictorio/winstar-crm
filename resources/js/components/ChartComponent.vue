<template>
  <div>
    <canvas ref="chart"></canvas>
  </div>
</template>

<script>
  export default {
    props: {
      type: { type: String },
      data: { type: Object },
      option: { type: Object },
    },
    data: () => ({
      chart: null,
    }),
    mounted () {
      this.renderChart()
    },
    watch: {
        data (newValue) {
          console.log('watch data')
          this.renderChart()
        },
    },
    methods: {
      renderChart () {
        this.chart = new Chart(this.$refs['chart'], {
          type: this.type,
          data: this.data,
          options: this.options,
        })
      },
    },
  }
</script>
