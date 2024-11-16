<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body text-hide fonticon-wrap text-center p-0">
                        <h2 class="font-weight-bolder">REPORTE DE INGRESOS POR PARTIDA PRESUPUESTAL</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-2">
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>Filtrar por Año</span>
                        <select class="form-control" v-model="selectAnio" @change="changeSelectAnio">
                            <option v-for="items in annoData[0]" :key="items.anno" :value="items.anno">{{ items.anno }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>TOTAL RECAUDADO {{ selectAnio }}</span>
                        <p class="font-weight-bolder">{{ TotalRecaudado }}</p>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 d-flex" style="padding: 0.1rem;" v-for="item in mesData[0]" :key="item.id">
                                <button class="btn btn-outline-secondary p-1 w-100"
                                    :disabled="selectMesNumero == item.n_mes && loading"
                                    :class="selectMesNumero == item.n_mes ? 'bg-gradient-warning' : ''"
                                    @click="changeMes(item.n_mes, item.mes)"><span v-html="isLoading(item.n_mes, item.mes)"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>TOTAL INGRESO {{ selectMesNombre.toLocaleUpperCase() }}</span>
                        <p class="font-weight-bolder">{{ TotalIngresoMes }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-1">
                            <div class="card-body text-hide fonticon-wrap text-center p-1 d-flex justify-content-around">
                                <button type="submit" class="btn btn-secondary"
                                    :class="idPartida == 169 ? 'bg-gradient-warning' : ''"
                                    @click="partidaPresupuestal(169)">Impuestos y Contribuciones Obligatorias</button>
                                <button type="submit" class="btn btn-secondary"
                                    :class="idPartida == 198 ? 'bg-gradient-warning' : ''"
                                    @click="partidaPresupuestal(198)">Venta
                                    de bienes y servicios administrativos</button>
                                <button type="submit" class="btn btn-secondary"
                                    :class="idPartida == 284 ? 'bg-gradient-warning' : ''"
                                    @click="partidaPresupuestal(284)">Otros
                                    Ingresos</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">INGRESOS POR PARTIDA GENERAL - {{
                                    selectMesNombre.toLocaleUpperCase() }}</h3>
                                <apexchart ref="chart" type="bar" style="height: 350px; width: 100%;"
                                    :options="chartOptions" :series="series"></apexchart>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center">IMPUESTOS Y CONTRIBUCIONES OBLIGATORIAS - {{
                                    selectMesNombre.toLocaleUpperCase() }}</h3>
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
                                <h3 class="font-medium-1 text-center"> INGRESOS POR PARTIDA DETALLADO - IMPUESTOS Y
                                    CONTRIBUCIONES OBLIGATORIAS - {{ selectMesNombre.toLocaleUpperCase() }}</h3>
                                <table class="table table-responsive table-hover d-lg-table">
                                    <thead>
                                        <tr>
                                            <th>Partida</th>
                                            <th class="text-center">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(items, index) in dataReportePartidaDetallado" :key="index">
                                            <td>{{ items.descripcion }}</td>
                                            <td class="text-right">S/{{ formatearNumero(items.monto) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
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
    props: {
        selectMesUrl: {
            type: String,
            default: '',
        },
        selectAnnoUrl: {
            type: String,
            default: '',
        },
        incomeTotalRecaudadoUrl: {
            type: String,
            default: '',
        },
        incomeTotalIngresoMesUrl: {
            type: String,
            default: '',
        },
        incomeIngresoPartidaGeneralUrl: {
            type: String,
            default: '',
        },
        incomeTotalIngresoDetalladoUrl: {
            type: String,
            default: '',
        },
        incomeReporteIngresoDetalladoUrl: {
            type: String,
            default: '',
        },
    },
    components: {
        'apexchart': VueApexCharts
    },
    data() {
        return {
            loading: false,
            selectAnio: '',
            selectMesNumero: 0,
            selectMesNombre: '',
            idPartida: 169,
            mesData: [],
            annoData: [],
            TotalRecaudado: 0,
            TotalIngresoMes: 0,
            dataReportePartidaDetallado: [],
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
                            if (value >= 1000000) {
                                return (value / 1000000).toString() + ' mill';
                            } else if (value >= 1000) {
                                return (value / 1000).toString() + ' mil';
                            } else {
                                return value.toString();
                            }
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
                        },
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
        }
    },
    created(){
        this.getAnio();
    },
    mounted() {
        this.idPartida = 169;
        this.selectMes();
        this.selectAnno();
        this.getTotalRecaudado();
        this.getTotalIngresoMes();
        this.getIngresoPartidaGeneral();
        this.getIngresoPartidaDetallado();
        this.getReportePartidaDetallado();
    },
    methods: {
        changeSelectAnio() {
            this.selectMes();
            this.getTotalRecaudado();
            this.getTotalIngresoMes();
            this.getIngresoPartidaGeneral();
            this.getIngresoPartidaDetallado();
            this.getReportePartidaDetallado();
            this.idPartida = 169;
        },
        changeMes(m_mes, mes) {
            this.selectMesNumero = m_mes;
            this.selectMesNombre = mes;
            this.getTotalIngresoMes();
            this.getIngresoPartidaGeneral();
            this.getIngresoPartidaDetallado();
            this.getReportePartidaDetallado();
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
            this.selectMesNumero = mes;
            this.selectMesNombre = nameMes;
        },
        partidaPresupuestal(id) {
            this.idPartida = id
            this.getIngresoPartidaDetallado();
            this.getReportePartidaDetallado();
        },
        async selectMes() {
            let obj = {
                selectAnio: this.selectAnio
            }
            this.mesData = [];
            await axios.post(this.selectMesUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        this.mesData.push(response.data.res)
                    }
                })
                .catch((error) => {
                    this.mesData = [];
                })
        },
        async selectAnno() {
            this.annoData = [];
            await axios.get(this.selectAnnoUrl)
                .then((response) => {
                    if (response.data.status) {
                        this.annoData.push(response.data.res)
                    }
                })
                .catch((error) => {
                    this.annoData = []
                })
        },
        async getTotalRecaudado() {
            let obj = {
                selectAnio: this.selectAnio
            }
            await axios.post(this.incomeTotalRecaudadoUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        this.TotalRecaudado = response.data.res[0].sub_total
                    }
                })
                .catch((error) => {
                    console.log(error)
                });
        },
        async getTotalIngresoMes() {
            let obj = {
                selectAnio: this.selectAnio,
                selectMes: this.selectMesNumero
            }
            await axios.post(this.incomeTotalIngresoMesUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        this.TotalIngresoMes = response.data.res[0].sub_total
                    }
                })
                .catch((error) => {
                    console.log(error)
                });
        },
        async getIngresoPartidaGeneral() {
            this.loading = true
            this.series[0].data = [];
            this.chartOptions.xaxis.categories.splice(0, this.chartOptions.xaxis.categories.length);
            let obj = {
                selectAnio: this.selectAnio,
                selectMes: this.selectMesNumero
            }
            await axios.post(this.incomeIngresoPartidaGeneralUrl, obj)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.loading = false
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
                    this.loading = true
                });
        },
        async getIngresoPartidaDetallado() {
            this.loading = true;
            this.series1[0].data = [];
            this.chartOptions1.xaxis.categories.splice(0, this.chartOptions1.xaxis.categories.length);
            let obj = {
                selectAnio: this.selectAnio,
                selectMes: this.selectMesNumero,
                id_partida: this.idPartida,
            }
            await axios.post(this.incomeTotalIngresoDetalladoUrl, obj)
                .then((response) => {
                    response.data.res.forEach(element => {
                        this.loading = false;
                        this.chartOptions1.xaxis.categories.push(element.descripcion.toString());
                        this.series1[0].data.push(element.monto);
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
        async getReportePartidaDetallado() {
            this.loading = true;
            let obj = {
                selectAnio: this.selectAnio,
                selectMes: this.selectMesNumero,
                id_partida: this.idPartida,
            }
            await axios.post(this.incomeReporteIngresoDetalladoUrl, obj)
                .then((response) => {
                    this.loading = false;
                    this.dataReportePartidaDetallado = response.data.res
                })
                .catch((error) => {
                    console.log(error)
                    this.loading = true;
                });
        },
        formatearNumero(numero) {
            if (isNaN(numero)) {
                return 'No es un número';
            }
            let partes = numero.toString().split('.');
            let parteEntera = partes[0];
            let parteDecimal = partes.length > 1 ? '.' + partes[1] : '';
            parteEntera = parteEntera.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            return parteEntera + parteDecimal;
        },
        isLoading(item, mes) {
            if (this.selectMesNumero == item && this.loading) {
                return `<div class="spinner"></div>`;
            } else {
                return mes;
            }
        }
        
    }
}
</script>
