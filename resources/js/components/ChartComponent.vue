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
      options: { type: Object },
    },
    data: () => ({
      chart: null,
    }),
    mounted () {
      this.renderChart()
    },
    watch: {
        data (newValue) {
          this.updateChart()
        },
        type (newValue) {
          this.updateChart()
        },
    },
    methods: {
      updateChart () {
        if (this.chart) {
          this.chart.destroy()
        }
        this.renderChart()
      },
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
