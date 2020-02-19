<template>
<div class="chart-modal">
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Tank charts</p>
        </header>
        <section class="modal-card-body" >
            <b-tabs v-on:input="log" v-if="!loading">
                <b-tab-item label="ph" >
                    <line-chart  :chartData="chartData.phData" :options="chartOptions"/>
                </b-tab-item>
                <b-tab-item label="gh" >
                    <line-chart  :chartData="chartData.ghData" :options="chartOptions"/>
                </b-tab-item>
                <b-tab-item label="Temperature" >
                    <line-chart  :chartData="chartData.tempData" :options="chartOptions"/>
                </b-tab-item>
                <b-tab-item label="kh" >
                    <line-chart  :chartData="chartData.khData" :options="chartOptions"/>
                </b-tab-item>
                <b-tab-item label="no3" >
                    <line-chart  :chartData="chartData.no3Data" :options="chartOptions"/>
                </b-tab-item>
                <b-tab-item label="ppm" >
                    <line-chart  :chartData="chartData.ppmData" :options="chartOptions"/>
                </b-tab-item>
                <b-tab-item label="us" >
                    <line-chart  :chartData="chartData.usData" :options="chartOptions"/>
                </b-tab-item>
            </b-tabs>
        </section>
    </div>
</div>
</template>
<script>
import LineChart from './LineChart.vue'
export default {
        props: {
            tankId: {
                type: Number
            }
        },

        data() {
            return {
                tabLabel: null,
                loading: true,
                measurements: [],
                ph: [],
                phLabels: [],
                phData: {
                        labels: [],
                        datasets: [{
                            label: 'ph',
                            data: [],
                        }]
                },
                //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! array
                chartData: {
                    phData: {
                        labels: [1, 2],
                        datasets: [{
                            label: 'ph',
                            data: [],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }, ]
                    },
                    ghData: {
                        labels: [],
                        datasets: [{

                            data: [],
                        }],
                    },
                    tempData: {
                        labels: [],
                        datasets: [{
                            label: 'temp',
                            data: [],
                        }],
                    },
                    khData: {
                        labels: [],
                        datasets: [{
                            label: 'kh',
                            data: [],
                        }],
                    },
                    no3Data: {
                        labels: [],
                        datasets: [{
                            label: 'temp',
                            data: [],
                        }],
                    },
                    ppmData: {
                        labels: [],
                        datasets: [{
                            label: 'temp',
                            data: [],
                        }],
                    },
                    usData: {
                        labels: [],
                        datasets: [{
                            label: 'temp',
                            data: [],
                        }],
                    },
                },
                chartOptions: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            }
        },
        methods: {
            fetchMes(tankId) {
                this.error = null;
                this.loading = true;
                let data;
                let labels = [];
                axios.get('auth/measurement/' + tankId)
                    .then(response => {
                        this.measurements = response.data.data;
                        labels = this.measurements.map(el=>el.created_at.substring(0, el.created_at.indexOf('T')));
                        this.chartData.phData.labels = labels;
                        this.chartData.ghData.labels = labels;
                        this.chartData.tempData.labels = labels;
                        this.chartData.khData.labels = labels;
                        this.chartData.no3Data.labels = labels;
                        this.chartData.ppmData.labels = labels;
                        this.chartData.usData.labels = labels;
                        this.chartData.phData.datasets[0].data = this.measurements.map(el=>el.ph);
                        this.chartData.ghData.datasets[0].data = this.measurements.map(el=>el.gh);
                        this.chartData.tempData.datasets[0].data = this.measurements.map(el=>el.tempC);
                        this.chartData.khData.datasets[0].data = this.measurements.map(el=>el.kh);
                        this.chartData.no3Data.datasets[0].data = this.measurements.map(el=>el.no3);
                        this.chartData.ppmData.datasets[0].data = this.measurements.map(el=>el.ppm);
                        this.chartData.usData.datasets[0].data = this.measurements.map(el=>el.us);
                        this.loading = false;
                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.message;
                    });
            },
            dataFromMes (measurements, el) {
                let data = [];
                measurements.forEach(element => {
                    data.push(element[el]);
                });
                    return [label,data];
            },
            log () {
                console.log(this.$options);
            }
        },
        created() {
            this.fetchMes(this.tankId);
        },
        components: {
            LineChart
        }
    }
</script>
<style>
.chart-modal {
    max-height: 90vh;
    min-height: 90vh;
}
</style>
