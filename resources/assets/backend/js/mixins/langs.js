
export default {
    filters: {
        
    },
    data() {
        return {
            datepicker_lang :{
                    firstDayOfWeek: 1,
                    weekdays: {
                    shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],         
                    }, 
                    months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
                    longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    },               
                },
            datatable_lang : {
                processing: "Procesando...",
                lengthMenu : "Mostrar _MENU_ registros por página",
                zeroRecords: "No hay ningun registro",
                info: "Mostrando _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros",
                infoFiltered: "(filtrados de _MAX_ registros)",
                sSearch:         "Buscar:",
                paginate: {
                    next: ">",
                    previous: "<"
                }
            },
        }
    },
    components: {
    },
    mounted() {
       
    },
    methods: {
     
    },
}
