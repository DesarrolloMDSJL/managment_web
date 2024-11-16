<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body text-hide fonticon-wrap text-left p-1 pb-2">
                        <h2 class="font-weight-bolder">REPORTE CENTRO - CUIS RAS</h2>
                        <div class="mt-3">
                            <label class="label-control" for="inputGroupSelect01">AREA ENCARGADA</label>
                            <div class="input-group mt-1">
                                <select class="form-control" id="inputGroupSelect01" v-model="selectCuisRas">
                                    <option selected disabled value="0">--Seleccione una opción--</option>
                                    <option v-for="item in cuisRasData[0]" :key="item.id" :value="item.id">{{item.descripcion}}</option>
                                </select>
                                <button class="btn btn-primary" @click="handleSearch($event)">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3" v-show="isActive">
                <div class="card mb-1">
                    <div class="card-body text-hide fonticon-wrap text-center p-0">
                        <h2 class="font-weight-bolder">{{ obtenerNombreArea() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row  mt-1" v-show="isActive">
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
                        <span>TOTAL RECAUDADO 2023</span>
                        <p class="font-weight-bolder">{{totalRecaudadoAnno}}</p>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>TOTAL RECAUDADO MES FEBRERO</span>
                        <p class="font-weight-bolder">{{ totalRecaudadoMes }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-10">
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
                                <h3 class="font-medium-1 text-center">RECORRIDO DIARIO DEL MES - {{
                                    selectMesNombre.toLocaleUpperCase() }}</h3>
                                <apexchart ref="chart1" type="line" style="height: 350px; width: 100%;"
                                    :options="chartOptions1" :series="series1"></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="font-medium-1 text-center"> REPORTE CUIS / RAS - MES - {{ selectMesNombre.toLocaleUpperCase() }}</h3>
                                <table class="table table-responsive table-hover d-lg-table">
                                    <thead>
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in dataReporteTupa" :key="index">
                                            <td>{{ item.descripcion }}</td>
                                            <td class="text-right">{{ item.sub_total }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr collapse="3">
                                            <td class="text-right">Total General</td>
                                            <td class="text-right">S/{{ sumarSubtotales() }}</td>
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
    props:{
        selectMesUrl:{
            type:String,
            default:'',
        },
        selectAnnoUrl:{
            type:String,
            default:'',
        },
        finesCuisRasUrl:{
            type:String,
            default:'',
        },
        finesTotalRecaudadoCuisRasUrl:{
            type:String,
            default:'',
        },
        finesTotalRecaudadoMesCuisRasUrl:{
            type:String,
            default:'',
        },
        finesIngresoMesCuisRasUrl:{
            type:String,
            default:'',
        },
        finesRecorridoDiaCuisRasUrl:{
            type:String,
            default:'',
        },
        finesListCuisRasUrl:{
            type:String,
            default:'',
        },
    },
    components: {
        'apexchart': VueApexCharts
    },
    data() {
        return {
            loading: false,
            isActive:false,
            selectAnio: '',
            selectMesNumero: 0,
            selectMesNombre: '',
            mesData: [],
            annoData: [],
            cuisRasData:[],
            selectCuisRas:'0',
            totalRecaudadoAnno:0.0,
            totalRecaudadoMes:0.0,
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
                            return value.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })
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
                    name: "Cantidad",
                    data: []
                }
            ],
            chartOptions1: {
                chart: {
                    height: 350,
                    type: 'line',
                    stacked: true,
                    zoom: {
                        enabled: true
                    }
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: [],
                }
            },
            dataReporteTupa:[]
        }
    },
    created(){
        this.getAnio();
    },
    mounted() {
        this.selectMes();
        this.selectAnno();
        this.getCuisRas();
        this.getTotalRecaudadoCuisRas();
        this.getTotalRecaudadoMesCuisRas();
        this.getIngresoMesCuisRas();
        this.getRecorridoDiaCuisRas();
        this.getListCuisRas();
        
    },
    methods: {
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
                    this.mesData = ""
                })
        },
        changeSelectAnio() {
            this.getTotalRecaudadoCuisRas();
            this.getTotalRecaudadoMesCuisRas();
            this.getIngresoMesCuisRas();
            this.getRecorridoDiaCuisRas();
            this.getListCuisRas();
        },
        changeMes(n_mes, mes){

            this.selectMesNumero = n_mes;
            this.selectMesNombre = mes;
            this.getTotalRecaudadoCuisRas();
            this.getTotalRecaudadoMesCuisRas();
            this.getRecorridoDiaCuisRas();
            this.getListCuisRas();
        },
        handleSearch(){      
            if(this.selectCuisRas=='0'){
                return;
            }else{
                this.getTotalRecaudadoCuisRas();
                this.getTotalRecaudadoMesCuisRas();
                this.getRecorridoDiaCuisRas();
                this.getIngresoMesCuisRas();
                this.getListCuisRas();
                this.obtenerNombreArea();
                this.isActive=true;
            }      
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
        async getCuisRas() {
            this.cuisRasData = [];
            await axios.get(this.finesCuisRasUrl)
                .then((response) => {
                    if (response.data.status) {
                        this.cuisRasData.push(response.data.res)
                    }
                })
                .catch((error) => {
                    this.cuisRasData = [];
                })
        },
        async getTotalRecaudadoCuisRas() {
            let obj = {
                selectAnio: this.selectAnio,
                selectCuisRas: this.selectCuisRas,
            }

            await axios.post(this.finesTotalRecaudadoCuisRasUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        this.totalRecaudadoAnno = response.data.res[0].sub_total
                    }
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async getTotalRecaudadoMesCuisRas() {
            this.loading=true;
            let obj = {
                selectAnio: this.selectAnio,
                selectCuisRas: this.selectCuisRas,
                selectMes: this.selectMesNumero,
            }
            await axios.post(this.finesTotalRecaudadoMesCuisRasUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        this.loading=false;
                        this.totalRecaudadoMes = response.data.res[0].sub_total
                    }
                })
                .catch((error) => {
                    this.loading=true;
                })
        },
        async getIngresoMesCuisRas() {
            this.loading=true;
            this.series[0].data = [];
            this.chartOptions.xaxis.categories.splice(0, this.chartOptions.xaxis.categories.length);
            let obj = {
                selectAnio: this.selectAnio,
                selectCuisRas: this.selectCuisRas,
            }

            await axios.post(this.finesIngresoMesCuisRasUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        response.data.res.forEach(element => {
                            this.loading=false;
                            this.chartOptions.xaxis.categories.push(element.mes.toString());
                            this.series[0].data.push(element.sub_total);
                        });
                        this.$refs.chart.updateOptions({
                            xaxis: {
                                categories: this.chartOptions.xaxis.categories,
                            },
                        });
                    }
                })
                .catch((error) => {
                    this.loading=true;
                })
        },
        async getRecorridoDiaCuisRas() {
            this.loading=true;
            this.series1[0].data = [];
            this.chartOptions1.xaxis.categories.splice(0, this.chartOptions1.xaxis.categories.length);
            let obj = {
                selectAnio: this.selectAnio,
                selectCuisRas: this.selectCuisRas,
                selectMes: this.selectMesNumero,
            }

            await axios.post(this.finesRecorridoDiaCuisRasUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        response.data.res.forEach(element => {
                            this.loading=false;
                            this.chartOptions1.xaxis.categories.push(element.mes.toString());
                            this.series1[0].data.push(element.sub_total);
                        });
                        this.$refs.chart1.updateOptions({
                            xaxis: {
                                categories: this.chartOptions1.xaxis.categories,
                            },
                        });
                    }
                })
                .catch((error) => {
                    this.loading=true;
                })
        },
        async getListCuisRas() {
            this.loading=true;
            this.dataReporteTupa = []
            let obj = {
                selectAnio: this.selectAnio,
                selectCuisRas: this.selectCuisRas,
                selectMes: this.selectMesNumero,
            }

            await axios.post(this.finesListCuisRasUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        this.loading=false;
                        this.dataReporteTupa = response.data.res
                    }
                })
                .catch((error) => {
                    this.loading=true;
                })
        },
        sumarSubtotales() {
            return this.dataReporteTupa.reduce((total, item) => total + parseFloat(item.total),0).toFixed(2);
        },
        obtenerNombreArea(){
            if (Array.isArray(this.cuisRasData[0])) {
                const elementoEncontrado = this.cuisRasData[0].filter(item => item.id==this.selectCuisRas);
                if(elementoEncontrado.length >0){
                        return elementoEncontrado[0].descripcion
                }else{
                    return 'AREA ENCARGADA';
                }
            }
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