<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body text-hide fonticon-wrap text-left p-1 pb-2">
                        <h2 class="font-weight-bolder">REPORTE DE INGRESOS POR PARTIDA PRESUPUESTAL</h2>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mt-3">
                                    <label class="label-control" for="inputGroupSelect01">DESDE :</label>
                                    <div class="input-group mt-1">
                                        <input type="date" class="form-control" v-model="fechaInicio">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-3">
                                    <label class="label-control" for="inputGroupSelect01">HASTA  :</label>
                                    <div class="input-group mt-1">
                                        <input type="date" class="form-control" v-model="fechaFin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-start align-items-end">
                                <div class="mt-3">
                                    <button class="btn btn-primary" @click="handleSearch()">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row  mt-1" v-show="isActive">
            <div class="col-md-2">
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>TOTAL INGRESO</span>
                        <p class="font-weight-bolder">{{totalRecaudadoAnno}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">TOTAL DE INGRESOS POR PARTIDA GENERAL</h3>
                                <apexchart ref="chart" type="bar" style="height: 350px; width: 100%;"
                                    :options="chartOptions" :series="series"></apexchart>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">TOP 5 PARTIDAS MAS RECAUDADAS</h3>
                                <apexchart ref="chart1" type="bar" style="height: 350px; width: 100%;"
                                    :options="chartOptions1" :series="series1"></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center"> TOTAL DE INGRESOS POR PARTIDA DETALLADO</h3>
                                 <apexchart ref="chart2" type="bar" style="height: 350px; width: 100%;"
                                    :options="chartOptions2" :series="series2"></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts';
export default {
    props:{
        departureTotalRecaudadoFechaRangoUrl:{
            type:String,
            default:'',
        },
        departureTotalIngresoPartidaUrl:{
            type:String,
            default:'',
        },
        departureTopCincoPartidaRecaudadoUrl:{
            type:String,
            default:'',
        },
        departureTotalIngresoPartidaDetalladoUrl:{
            type:String,
            default:'',
        },
    },
    components: {
        'apexchart': VueApexCharts
    },
    data() {
        return{
            /* selectAnio:'2024', */
            mesData:[],
            annoData:[],
            totalRecaudadoAnno:0.0,
            fechaInicio:'',
            fechaFin:'',
            series: [
                {
                    data: []
                }
            ],
            chartOptions: {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    events: {
                        click: function (chart, w, e) {
                            // console.log(chart, w, e)
                        }
                    },
                },
                colors: ['#EDFEFE', '#C7CEEA', '#FFDAC1', '#FF9AA2', '#FFFFD8', '#B5EAD7', '#D8E4FF', '#D8FFE0', '#F4D8FF', '#FFD8E1', '#FFFFD8', '#FFE9D8'],
                plotOptions: {
                    bar: {
                        borderRadius: 1,
                        columnWidth: '55%',
                        distributed: true,
                        horizontal: true,
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '09px',
                                    fontWeight: 900
                                },
                                formatter: function (w) {
                                    const formattedTotal = w.toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                    });
                                    return formattedTotal;
                                },
                            }
                        },
                        borderColor: '#000000',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                xaxis: {
                    type: 'category',
                    categories: [],
                    labels: {
                        style: {
                            fontSize: '12px'
                        },
                        formatter: function (value) {
                            return value.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })
                        }
                    }
                },
                yaxis: {
                    labels: {
                        /*  formatter: function (value) {
                             if (value >= 1000000) {
                                 return (value / 1000000).toString() + ' mill';
                             } else if (value >= 1000) {
                                 return (value / 1000).toString() + ' mil';
                             } else {
                                 return value.toString();
                             }
                         }, */
                    },
                },
                tooltip: {
                    custom: function ({ seriesIndex, dataPointIndex, w }) {
                        return `<div class="p-1">
                                    <h5 class="text-center">${w.globals.labels[dataPointIndex]}</h5>
                                    <p>S/${w.globals.series[seriesIndex][dataPointIndex].toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        })}<p>
                                </div>`;
                    },
                },
            },
            series1: [
                {
                    data: []
                }
            ],
            chartOptions1: {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    events: {
                        click: function (chart, w, e) {
                            // console.log(chart, w, e)
                        }
                    },
                },
                colors: ['#EDFEFE', '#C7CEEA', '#FFDAC1', '#FF9AA2', '#FFFFD8', '#B5EAD7', '#D8E4FF', '#D8FFE0', '#F4D8FF', '#FFD8E1', '#FFFFD8', '#FFE9D8'],
                plotOptions: {
                    bar: {
                        borderRadius: 1,
                        columnWidth: '55%',
                        distributed: true,
                        horizontal: true,
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '09px',
                                    fontWeight: 900
                                },
                                formatter: function (w) {
                                    const formattedTotal = w.toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                    });
                                    return formattedTotal;
                                },
                            }
                        },
                        borderColor: '#000000',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                xaxis: {
                    type: 'category',
                    categories: [],
                    labels: {
                        style: {
                            fontSize: '12px'
                        },
                        formatter: function (value) {
                            return value.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })
                        }
                    }
                },
                yaxis: {
                    labels: {
                        /*  formatter: function (value) {
                             if (value >= 1000000) {
                                 return (value / 1000000).toString() + ' mill';
                             } else if (value >= 1000) {
                                 return (value / 1000).toString() + ' mil';
                             } else {
                                 return value.toString();
                             }
                         }, */
                    },
                },
                tooltip: {
                    custom: function ({ seriesIndex, dataPointIndex, w }) {
                        return `<div class="p-1">
                                    <h5 class="text-center">${w.globals.labels[dataPointIndex]}</h5>
                                    <p>S/${w.globals.series[seriesIndex][dataPointIndex].toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        })}<p>
                                </div>`;
                    },
                },
            },
            series2: [
                {
                    data: []
                }
            ],
            chartOptions2: {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    events: {
                        click: function (chart, w, e) {
                            // console.log(chart, w, e)
                        }
                    },
                },
                colors: ['#EDFEFE', '#C7CEEA', '#FFDAC1', '#FF9AA2', '#FFFFD8', '#B5EAD7', '#D8E4FF', '#D8FFE0', '#F4D8FF', '#FFD8E1', '#FFFFD8', '#FFE9D8'],
                plotOptions: {
                    bar: {
                        borderRadius: 1,
                        columnWidth: '55%',
                        distributed: true,
                        horizontal: true,
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '09px',
                                    fontWeight: 900
                                },
                                formatter: function (w) {
                                    const formattedTotal = w.toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2,
                                    });
                                    return formattedTotal;
                                },
                            }
                        },
                        borderColor: '#000000',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                xaxis: {
                    type: 'category',
                    categories: [],
                    labels: {
                        style: {
                            fontSize: '12px'
                        },
                        formatter: function (value) {
                            return value.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })
                        }
                    }
                },
                yaxis: {
                    labels: {
                        /*  formatter: function (value) {
                             if (value >= 1000000) {
                                 return (value / 1000000).toString() + ' mill';
                             } else if (value >= 1000) {
                                 return (value / 1000).toString() + ' mil';
                             } else {
                                 return value.toString();
                             }
                         }, */
                    },
                },
                tooltip: {
                    custom: function ({ seriesIndex, dataPointIndex, w }) {
                        return `<div class="p-1">
                                    <h5 class="text-center">${w.globals.labels[dataPointIndex]}</h5>
                                    <p>S/${w.globals.series[seriesIndex][dataPointIndex].toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        })}<p>
                                </div>`;
                    },
                },
            },
            isActive:false
        }
    },
    mounted() {
      
    },
    methods: {
        handleSearch(){
            if(this.fechaFin==''){
                return;
            }else{
                if(this.fechaInicio==''){
                    return;
                }else{
                    this.getTotalRecaudadoFechaRango();
                    this.getIngresoPartidaGeneral();
                    this.getTopCincoPartidasRecaudados();
                    this.getTotalIngresoPartidaDetallado();
                    this.isActive=true;
                }
            }
        },
        async getTotalRecaudadoFechaRango() {
            let obj = {
                selectAnio: this.selectAnio,
                fechaInicio: this.fechaInicio,
                fechaFin: this.fechaFin,
            }

            await axios.post(this.departureTotalRecaudadoFechaRangoUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        this.totalRecaudadoAnno = response.data.res[0].sub_total
                    }
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getIngresoPartidaGeneral() {
            this.series[0].data = [];
            this.chartOptions.xaxis.categories.splice(0, this.chartOptions.xaxis.categories.length);
            let obj = {
                fechaInicio: this.fechaInicio,
                fechaFin: this.fechaFin,
            }
            await axios.post(this.departureTotalIngresoPartidaUrl, obj)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.chartOptions.xaxis.categories.push(element.descripcion.toString());
                        this.series[0].data.push(element.monto);
                    });
                    this.$refs.chart.updateOptions({
                        xaxis: {
                            categories: this.chartOptions.xaxis.categories,
                        },
                    });
                })
                .catch((error) => {
                    console.log(error)
                });
        },
        async getTopCincoPartidasRecaudados() {
            this.series1[0].data = [];
            this.chartOptions1.xaxis.categories.splice(0, this.chartOptions1.xaxis.categories.length);
            let obj = {
                fechaInicio: this.fechaInicio,
                fechaFin: this.fechaFin,
            }
            await axios.post(this.departureTopCincoPartidaRecaudadoUrl, obj)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.chartOptions1.xaxis.categories.push(element.descrip.toString());
                        this.series1[0].data.push(element.sub_total);
                    });
                    this.$refs.chart1.updateOptions({
                        xaxis: {
                            categories: this.chartOptions1.xaxis.categories,
                        },
                    });
                })
                .catch((error) => {
                    console.log(error)
                });
        },
        async getTotalIngresoPartidaDetallado() {
            this.series2[0].data = [];
            this.chartOptions2.xaxis.categories.splice(0, this.chartOptions2.xaxis.categories.length);
            let obj = {
                fechaInicio: this.fechaInicio,
                fechaFin: this.fechaFin,
            }
            await axios.post(this.departureTotalIngresoPartidaDetalladoUrl, obj)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.chartOptions2.xaxis.categories.push(element.descrip.toString());
                        this.series2[0].data.push(element.sub_total);
                    });
                    this.$refs.chart2.updateOptions({
                        xaxis: {
                            categories: this.chartOptions2.xaxis.categories,
                        },
                    });
                })
                .catch((error) => {
                    console.log(error)
                });
        },
    }
}
</script>