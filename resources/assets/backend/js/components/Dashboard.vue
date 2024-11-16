<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>Filtrar por Año</span>
                        <select class="form-control" v-model="selectAnio" @change="changeSelectAnio">
                            <option v-for="items in annoData[0]" :key="items.anno" :value="items.anno">{{ items.anno }}</option>
                        </select>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>TOTAL</span>
                        <p class="font-weight-bolder">S/{{ total }}</p>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 d-flex" style="padding: 0.1rem;" v-for="item in mesData[0]" :key="item.id">
                                <button class="btn btn-outline-secondary p-1 w-100" :class="selectMesId == item.n_mes ? 'bg-gradient-warning' : ''" @click="changeMes(item.n_mes, item.mes)"><span v-html="isLoading(item.n_mes, item.mes)"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>TOTAL TUPA/TUSNE</span>
                        <p class="font-weight-bolder">S/{{ totalTupaTusne }}</p>
                        <span class="mt-2">PORCENTAJE RECAUDADO</span>
                        <p class="font-weight-bolder">{{ porcentaje1 }} %</p>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>TOTAL MULTAS</span>
                        <p class="font-weight-bolder">S/{{ totalMultas }}</p>
                        <span class="mt-2">PORCENTAJE RECAUDADO</span>
                        <p class="font-weight-bolder">{{ porcentaje2 }} %</p>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>TOTAL TRIBUTARIA</span>
                        <p class="font-weight-bolder">S/{{ totalTributaria }}</p>
                        <span class="mt-2">PORCENTAJE RECAUDADO</span>
                        <p class="font-weight-bolder">{{ porcentaje3 }} %</p>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-1">
                            <div class="card-body text-hide fonticon-wrap text-center p-0">
                                <h2 class="font-weight-bolder">CONCEPTO DE TASAS DEL TUPA Y TUSNE</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">TOTAL DE INGRESOS POR MES</h3>
                                <apexchart ref="chart" type="bar" style="height: 350px; width: 100%;"
                                    :options="chartOptions" :series="series"></apexchart>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">SUBGERENCIAS QUE MÁS RECAUDARON EN EL MES {{ selectMesNombre.toLocaleUpperCase() }}</h3>
                                <apexchart ref="chart1" type="bar" style="height: 350px; width: 100%;"
                                    :options="chartOptions1" :series="series1"></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-1">
                            <div class="card-body text-hide fonticon-wrap text-center p-0">
                                <h2 class="font-weight-bolder">RECAUDACIÓN DE MULTAS</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">TOTAL DE INGRESOS POR MES</h3>
                                <apexchart ref="chart2" type="bar" style="height: 350px; width: 100%;" :options="chartOptions2" :series="series2"></apexchart>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">CONCEPTOS DEL CUIS QUE MÁS RECAUDARON EN EL MES {{ selectMesNombre.toLocaleUpperCase() }}</h3>
                                <apexchart ref="chart3" type="bar" style="height: 350px; width: 100%;" :options="chartOptions3" :series="series3"></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-1">
                            <div class="card-body text-hide fonticon-wrap text-center p-0">
                                <h2 class="font-weight-bolder">RECAUDACIÓN TRIBUTARIA</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">TOTAL DE INGRESOS POR MES</h3>
                                <apexchart ref="chart4" type="bar" style="height: 350px; width: 100%;" :options="chartOptions4" :series="series4"></apexchart>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">TRIBUTOS QUE MÁS RECAUDARON EN EL MES {{ selectMesNombre.toLocaleUpperCase() }}</h3>
                                <apexchart ref="chart5" type="bar" style="height: 350px; width: 100%;" :options="chartOptions5" :series="series5"></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import VueApexCharts from 'vue-apexcharts';
import axios from 'axios';
export default {
    props:{
        percentageTotalUrl:{
            type:String,
            default:'',
        },
        selectMesUrl:{
            type:String,
            default:'',
        },
        selectAnnoUrl:{
            type:String,
            default:'',
        },
        selectTotalIngresoTupaTusneUrl:{
            type:String,
            default:'',
        },
        selectTopRecaudacionAreaUrl:{
            type:String,
            default:'',
        },
        selectTotalIngresoMesMultasUrl:{
            type:String,
            default:'',
        },
        selectRecaudacionMesMultasUrl:{
            type:String,
            default:'',
        },
        selectTotalIngresoMesTributariaUrl:{
            type:String,
            default:'',
        },
        selectRecaudacionMesTributariaUrl:{
            type:String,
            default:'',
        }
    },
    components: {
        'apexchart': VueApexCharts
    },
    data() {
        return {
            loading: false,
            porcentaje1: '',
            porcentaje2: '',
            porcentaje3: '',
            total: '',
            totalMultas: '',
            totalTributaria: '',
            totalTupaTusne: '',
            mesData: [],
            annoData: [],
            series: [
                {
                    data: []
                }
            ],
            chartOptions: {
                chart: {
                    height: 350,
                    type: 'bar',
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
                        horizontal: false,
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
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toString() + ' mill';
                            } else if (value >= 1000) {
                                return (value / 1000).toString() + ' mil';
                            } else {
                                return value.toString();
                            }
                        },
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
                    height: 350,
                    type: 'bar',
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
                        horizontal: false,
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
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toString() + ' mill';
                            } else if (value >= 1000) {
                                return (value / 1000).toString() + ' mil';
                            } else {
                                return value.toString();
                            }
                        },
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
                    height: 350,
                    type: 'bar',
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
                        horizontal: false,
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
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toString() + ' mill';
                            } else if (value >= 1000) {
                                return (value / 1000).toString() + ' mil';
                            } else {
                                return value.toString();
                            }
                        },
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
            series3: [
                {
                    data: []
                }
            ],
            chartOptions3: {
                chart: {
                    height: 350,
                    type: 'bar',
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
                        horizontal: false,
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
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toString() + ' mill';
                            } else if (value >= 1000) {
                                return (value / 1000).toString() + ' mil';
                            } else {
                                return value.toString();
                            }
                        },
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
            series4: [
                {
                    data: []
                }
            ],
            chartOptions4: {
                chart: {
                    height: 350,
                    type: 'bar',
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
                        horizontal: false,
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
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toString() + ' mill';
                            } else if (value >= 1000) {
                                return (value / 1000).toString() + ' mil';
                            } else {
                                return value.toString();
                            }
                        },
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
            series5: [
                {
                    data: []
                }
            ],
            chartOptions5: {
                chart: {
                    height: 350,
                    type: 'bar',
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
                        horizontal: false,
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
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toString() + ' mill';
                            } else if (value >= 1000) {
                                return (value / 1000).toString() + ' mil';
                            } else {
                                return value.toString();
                            }
                        },
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
            selectAnio: '',
            selectMesId: 0,
            selectMesNombre: '',
        }
    },
    computed: {
        ...mapGetters('Percentage', ['message'])
    },
    created(){
        this.getAnio();
    },
    mounted() {
        this.PercentageTotal();
        this.selectMes();
        this.getTotalIngresoMesTupaTusne();
        this.getTotalRecaudacionArea();
        this.getTotalIngresoMesMultas();
        this.getTotalRecaudacionMesMultas();
        this.getTotalIngresoMesTributaria();
        this.getTotalRecaudacionMesTributaria();
        this.selectAnno();
        
    },
    methods: {
        async PercentageTotal() {
            let form = {
                selectAnio: this.selectAnio
            }
            await axios.post(this.percentageTotalUrl, form)
                .then((response) => {
                    this.total = response.data.total;
                    this.totalTupaTusne = response.data.totalTupaTusne;
                    this.totalMultas = response.data.totalMultas;
                    this.totalTributaria = response.data.totalTributaria;
                    this.porcentaje1 = response.data.porcentaje1;
                    this.porcentaje2 = response.data.porcentaje2;
                    this.porcentaje3 = response.data.porcentaje3;
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        changeSelectAnio() {
            this.selectMesId = 1;
            this.selectMesNombre = 'ENERO';
            this.PercentageTotal();
            this.getTotalIngresoMesTupaTusne();
            this.getTotalRecaudacionArea();
            this.getTotalIngresoMesMultas();
            this.getTotalRecaudacionMesMultas();
            this.getTotalIngresoMesTributaria();
            this.getTotalRecaudacionMesTributaria();
        },
        changeMes(n_mes, mes){
            this.selectMesId = n_mes;
            this.selectMesNombre = mes;
            this.getTotalRecaudacionArea();
            this.getTotalRecaudacionMesMultas();
            this.getTotalRecaudacionMesTributaria();
        },
        getAnio(){
            const date = new Date();
            const anio = date.getFullYear();
            const mes = date.getMonth() + 1;
            const numberMes = date.getMonth();
            const MesText = [
                "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO",
                "JULIO", "AGOSTO", "SETIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"
            ];
            const  nameMes = MesText[numberMes];
            this.selectAnio = anio;
            this.selectMesId = mes;
            this.selectMesNombre = nameMes;
        },
        async selectMes() {
            let obj = {
                selectAnio :this.selectAnio
            }
            this.mesData=[];
            await axios.post(this.selectMesUrl,obj)
                .then((response) => {
                    if (response.data.status) {
                        this.mesData.push(response.data.res)
                    }
                })
                .catch((error) => {
                    this.mesData = ""
                })
        },
        async selectAnno() {
            this.annoData=[];
            await axios.get(this.selectAnnoUrl)
                .then((response) => {
                    if (response.data.status) {
                        this.annoData.push(response.data.res)
                    }
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getTotalIngresoMesTupaTusne() {
            this.loading = true;
            this.series[0].data = [];
            this.chartOptions.xaxis.categories.splice(0, this.chartOptions.xaxis.categories.length);
            let form = {
                selectAnio: this.selectAnio
            };
            await axios.post(this.selectTotalIngresoTupaTusneUrl, form)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.loading = false;
                        this.chartOptions.xaxis.categories.push(element.mes.toString());
                        this.series[0].data.push(element.sub_total);
                    });
                    this.$refs.chart.updateOptions({
                        xaxis: {
                            categories: this.chartOptions.xaxis.categories,
                        },
                    });
                })
                .catch((error) => {
                    console.log(error)
                    this.loading = true;
                });
        },
        async getTotalRecaudacionArea() {
            this.loading = true;
            this.series1[0].data = [];
            this.chartOptions1.xaxis.categories.splice(0, this.chartOptions1.xaxis.categories.length);
            let form = {
                selectAnio: this.selectAnio,
                selectMes:this.selectMesId
            };
            await axios.post(this.selectTopRecaudacionAreaUrl, form)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.loading = false;
                        this.chartOptions1.xaxis.categories.push(element.descripcion.toString());
                        this.series1[0].data.push(element.total);
                    });
                    this.$refs.chart1.updateOptions({
                        xaxis: {
                            categories: this.chartOptions1.xaxis.categories,
                        },
                    });
                })
                .catch((error) => {
                    console.log(error)
                    this.loading = true;
                });
        },
        async getTotalIngresoMesMultas() {
            this.loading = true;
            this.series2[0].data = [];
            this.chartOptions2.xaxis.categories.splice(0, this.chartOptions2.xaxis.categories.length);
            let form = {
                selectAnio: this.selectAnio
            };
            await axios.post(this.selectTotalIngresoMesMultasUrl, form)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.loading = false;
                        this.chartOptions2.xaxis.categories.push(element.mes.toString());
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
                    this.loading = true;
                });
        },
        async getTotalRecaudacionMesMultas() {
            this.loading = true;
            this.series3[0].data = [];
            this.chartOptions3.xaxis.categories.splice(0, this.chartOptions3.xaxis.categories.length);
            let form = {
                selectAnio: this.selectAnio,
                selectMes:this.selectMesId
            };
            await axios.post(this.selectRecaudacionMesMultasUrl, form)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.loading = false;
                        this.chartOptions3.xaxis.categories.push(element.mes.toString());
                        this.series3[0].data.push(element.sub_total);
                    });
                    this.$refs.chart3.updateOptions({
                        xaxis: {
                            categories: this.chartOptions3.xaxis.categories,
                        },
                    });
                })
                .catch((error) => {
                    console.log(error)
                    this.loading = true
                });
        },
        async getTotalIngresoMesTributaria() {
            this.loading = true;
            this.series4[0].data = [];
            this.chartOptions4.xaxis.categories.splice(0, this.chartOptions4.xaxis.categories.length);
            let form = {
                selectAnio: this.selectAnio
            };
            await axios.post(this.selectTotalIngresoMesTributariaUrl, form)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.loading = false;
                        this.chartOptions4.xaxis.categories.push(element.mes.toString());
                        this.series4[0].data.push(element.sub_total);
                    });
                    this.$refs.chart4.updateOptions({
                        xaxis: {
                            categories: this.chartOptions4.xaxis.categories,
                        },
                    });
                })
                .catch((error) => {
                    console.log(error)
                    this.loading = true;
                });
        },
        async getTotalRecaudacionMesTributaria() {
            this.loading = true;
            this.series5[0].data = [];
            this.chartOptions5.xaxis.categories.splice(0, this.chartOptions5.xaxis.categories.length);
            let form = {
                selectAnio: this.selectAnio,
                selectMes:this.selectMesId
            };
            await axios.post(this.selectRecaudacionMesTributariaUrl, form)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.loading = false;
                        this.chartOptions5.xaxis.categories.push(element.mes.toString());
                        this.series5[0].data.push(element.sub_total);
                    });
                    this.$refs.chart5.updateOptions({
                        xaxis: {
                            categories: this.chartOptions5.xaxis.categories,
                        },
                    });
                })
                .catch((error) => {
                    console.log(error)
                    this.loading = true;
                });
        },
        isLoading(item, mes) {
            if (this.selectMesId == item && this.loading) {
                return `<div class="spinner"></div>`;
            } else {
                return mes;
            }
        }
    }
}
</script>
