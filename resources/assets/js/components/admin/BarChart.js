import { Bar} from 'vue-chartjs'

export default Bar.extend({
  props: {
    chartData: {
      type: Array | Object,
      required: false
    },

    chartLabels: {
      type: Array,
      required: true
    }
  },

  data() {
    return {
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    }
  },

  mounted () {
    this.renderChart({
      labels: this.chartLabels,
      datasets: [
        {
          label: 'Aujourdh\'hui',
          backgroundColor: '#ddd',
          data: this.chartData
        }
      ]
    }, this.options)
  }
})