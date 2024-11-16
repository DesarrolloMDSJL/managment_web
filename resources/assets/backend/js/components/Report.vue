<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-1">
                    <div class="card-body text-hide fonticon-wrap text-left p-1 pb-2">
                        <h2 class="font-weight-bolder">REPORTE CENTRO - COSTO TUPA/TUSNE</h2>
                        <div class="mt-3">
                            <label class="label-control" for="inputGroupSelect01">AREA ENCARGADA</label>
                            <div class="input-group mt-1">
                                <select class="form-control" id="inputGroupSelect01" v-model="selectArea" >
                                    <option selected disabled value="0">--Seleccione una opción--</option>
                                    <option v-for="item in  areaData[0]" :key="item.unidad_id" :value="item.unidad_id">{{
                                        item.descripcion }}</option>
                                </select>
                                <button class="btn btn-primary" @click="handleSearch()">Buscar</button>
                                
                                <button v-if="usuarioId == 662" type="button" class="btn btn-primary mx-3" data-toggle="modal" data-target="#ModalReporte">Ver Reporte</button>
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
                        <span>TOTAL RECAUDADO {{ selectAnio }}</span>
                        <p class="font-weight-bolder">{{ totalRecaudadoAnno }}</p>
                    </div>
                </div>
                <div class="card mt-md-n2">
                    <div class="card-body text-center">
                        <span>TOTAL RECAUDADO MES {{ selectMesNombre.toUpperCase() }}</span>
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
                                <h3 class="font-medium-1 text-center">IMPUESTOS Y CONTRIBUCIONES OBLIGATORIAS - {{
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
                                <h3 class="font-medium-1 text-center"> INGRESOS POR PARTIDA DETALLADO - IMPUESTOS Y
                                    CONTRIBUCIONES OBLIGATORIAS - {{ selectMesNombre.toLocaleUpperCase() }}</h3>
                                <table class="table table-responsive table-hover d-lg-table">
                                    <thead>
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Monto c/u</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in dataReporteTupa" :key="index">
                                            <td>{{ item.descripcion }}</td>
                                            <td class="text-center">{{ item.cantidad }}</td>
                                            <td class="text-center">S/.{{ item.unitario }}</td>
                                            <td class="text-right">{{ item.sub_total }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr collapse="3">
                                            <td></td>
                                            <td></td>
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


        <div class="modal fade" id="ModalReporte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reporte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" v-model="dateStart">
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" v-model="dateFinish">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="download">Descargar</button>
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
        reportUnidadOrganicaUrl:{
            type:String,
            default:'',
        },
        reportTotalRecaudadoUnidadOrganicaUrl:{
            type:String,
            default:'',
        },
        reportIngresoMesUnidadOrganicaUrl:{
            type:String,
            default:'',
        },
        reportTotalRecaudadoMesUnidadOrganicaUrl:{
            type:String,
            default:'',
        },
        reportRecoridoDiarioMesUnidadOrganicaUrl:{
            type:String,
            default:'',
        },
        reportRecoridoTupaMesUnidadOrganicaUrl:{
            type:String,
            default:'',
        },
        unidadId:{
            type:Number,
            default:0,
        },
        usuarioId:{
            type:Number,
            default:0,
        }
    },
    components: {
        'apexchart': VueApexCharts
    },
    data() {
        return {
            loading: false,
            isActive:false,
            selectArea: '0',
            selectAnio: '',
            selectMesNumero: 0,
            selectMesNombre: '',
            totalRecaudadoAnno: 0.0,
            totalRecaudadoMes: 0.0,
            dateStart:null,
            dateFinish:null,
            mesData: [],
            annoData: [],
            areaData: [],
            dataReporteTupa: [],
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
        }
    },
    created(){
        this.getAnio();
    },
    mounted() {
        this.selectMes();
        this.selectAnno();
        this.getUnidadOrganica();
       /*  this.selectArea=this.unidadId */
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
            this.getTotalRecaudadoUnidadOrganica();
            this.getIngresoMesUnidadOrganica();
            this.getTotalRecaudadoMesUnidadOrganica();
            this.getRecorridoDiarioMesUnidadOrganica();
            this.getReporteTupaMesUnidadOrganica();
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
        changeMes(n_mes, mes) {
            this.selectMesNumero = n_mes;
            this.selectMesNombre = mes;
            this.getTotalRecaudadoUnidadOrganica();
            this.getIngresoMesUnidadOrganica();
            this.getRecorridoDiarioMesUnidadOrganica();
            this.getReporteTupaMesUnidadOrganica();
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

        async getUnidadOrganica() {
            this.areaData = [];
            await axios.get(this.reportUnidadOrganicaUrl)
                .then((response) => {
                    if (response.data.status) {
                        this.areaData.push(response.data.res)
                    }
                })
                .catch((error) => {
                    this.areaData = []
                })
        },

        handleSearch() {
            if(this.selectArea=='0'){
                return;
            }else{
                this.getTotalRecaudadoUnidadOrganica();
                this.getIngresoMesUnidadOrganica();
                this.getTotalRecaudadoMesUnidadOrganica();
                this.getRecorridoDiarioMesUnidadOrganica();
                this.getReporteTupaMesUnidadOrganica();
                this.isActive= true;
            }
        },

        async getTotalRecaudadoUnidadOrganica() {
            let obj = {
                selectAnio: this.selectAnio,
                selectArea: this.selectArea,
            }

            await axios.post(this.reportTotalRecaudadoUnidadOrganicaUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        this.totalRecaudadoAnno = response.data.res[0].sub_total
                    }
                })
                .catch((error) => {
                   console.log(error)
                })
        },

        async getIngresoMesUnidadOrganica() {
            let obj = {
                selectAnio: this.selectAnio,
                selectArea: this.selectArea,
                selectMes: this.selectMesNumero,
            }
            await axios.post(this.reportIngresoMesUnidadOrganicaUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        this.totalRecaudadoMes = response.data.res[0].sub_total
                    }
                })
                .catch((error) => {
                    console.log(error)
                })
        },

        async getTotalRecaudadoMesUnidadOrganica() {
            this.loading=true;
            this.series[0].data = [];
            this.chartOptions.xaxis.categories.splice(0, this.chartOptions.xaxis.categories.length);
            let obj = {
                selectAnio: this.selectAnio,
                selectArea: this.selectArea,
            }

            await axios.post(this.reportTotalRecaudadoMesUnidadOrganicaUrl, obj)
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
                    this.loading=true
                })
        },

        async getRecorridoDiarioMesUnidadOrganica() {
            this.loading=true;
            this.series1[0].data = [];
            this.chartOptions1.xaxis.categories.splice(0, this.chartOptions1.xaxis.categories.length);
            let obj = {
                selectAnio: this.selectAnio,
                selectArea: this.selectArea,
                selectMes: this.selectMesNumero,
            }

            await axios.post(this.reportRecoridoDiarioMesUnidadOrganicaUrl, obj)
                .then((response) => {
                    if (response.data.status) {
                        response.data.res.forEach(element => {
                            this.loading=false;
                            this.chartOptions1.xaxis.categories.push(element.dia_mes.toString());
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

        async getReporteTupaMesUnidadOrganica() {
            this.loading=true;
            this.dataReporteTupa=[]
            let obj = {
                selectAnio: this.selectAnio,
                selectArea: this.selectArea,
                selectMes: this.selectMesNumero,
            }

            await axios.post(this.reportRecoridoTupaMesUnidadOrganicaUrl, obj)
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
            if (Array.isArray(this.areaData[0])) {
                const elementoEncontrado = this.areaData[0].filter(item => item.unidad_id==this.selectArea);
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
        },
        download(){
            try {
                const newWindow = window.open(`/income-reporte-presupuesto-area?date_start=${this.dateStart}&date_finish=${this.dateFinish}`, '_blank');
                if (newWindow) {
                    newWindow.focus();
                }
            } catch (error) {
                return error;
            }
        }
    }
}
</script>