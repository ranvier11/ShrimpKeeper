
<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: {
      chartData: {
          type: Object,
          required: false
      },
      options: {
          type: Object,
          required: false
      }
  },
  mounted () {
    this.renderChart(this.chartData, this.options)
  }
}
</script>

<style>
</style>
