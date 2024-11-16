<template>
    <table
        id="current_table"
        class="table table-bordered dt-responsive nowrap"
        style="border-collapse: collapse; border-spacing: 0; width: 100%"
    ></table>
</template>

<script>
export default {
    props: {
        urlList: {
            type: String,
            default: ""
        },
        urlDetail: {
            type: String,
            default: ""
        },
        urlDelete: {
            type: String,
            default: ""
        }
    },
    data() {
        return {
            datatable: undefined
        };
    },
    components: {},
    mounted() {
        this.$parent.$on(
            "refresh",
            function() {
                this.datatable.ajax.reload();
            }.bind(this)
        );

        this.fillTable();
    },
    methods: {
        fillTable: function() {
            let current_url = this.urlList;
            let token = document.head.querySelector('meta[name="csrf-token"]').content;
            let lang = this.$parent.lang;
            console.log(lang)
            this.datatable = $("#current_table").DataTable({      
                language:lang,        
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: current_url,
                    type: "POST",
                    data: {
                        _token: token
                    }
                },
                columns: [
                    { data: "n", title: "N°", width: 20, sortable: false },
                    {
                        data: "id",
                        title: "id",
                        visible: false,
                        sortable: false
                    },               
                    { data: "name", title: "Nombre", sortable: false },     
                    { data: "lastname", title: "Apellido", sortable: false }, 
                    { data: "document", title: "Documento", sortable: false },
                    { data: "numberResoInit", title: "Nro Reso Inicio", sortable: false }, 
                    { data: "numberResoEnd", title: "Nro Reso Cese", sortable: false }, 
                    {
                        data: null,
                        title: "Estado",
                        sortable: false,
                        render: function(data, type, row) {
                           
                            if (row.isActive === '1') {
                                return '<span class="badge badge-success">Habilitado</span>';
                            } else {
                                return '<span class="badge badge-warning">Inhabilitado</span>';
                            }
                        }
                    },   
                    {
                        data: null,
                        title: "Rol",
                        sortable: false,
                        render: function(data, type, row) {
                            let rolType  = "Administrador"
                            if (row.isActive === 'F') {
                                rolType = "Fedatario"
                            } 

                            return `<span class="badge badge-success">${rolType}</span>`;
                        }
                    },                 
                    {
                        data: null,
                        title: "Acciones",
                        width: 100,
                        sortable: false,
                        render: function(data, type, row) {
                            return "<a href='javascript:;' class='btn btn-sm btn-clean btn-icon btn-icon-md edit' title='Editar'><i class='fas fa-edit'></i></a><a href='javascript:;' class='btn btn-sm btn-clean btn-icon btn-icon-md delete' title='Delete'><i class='fas fa-trash'></i></a>";
                        }
                    }
                ]
            });

            $("#current_table tbody").on(
                "click",
                ".edit",
                function(event) {
                    let row = $(event.target).parents("tr");
                    if (row.hasClass("child")) row = row.prev();
                    let id = this.datatable.row(row).data().id;

                    axios
                        .post(this.urlDetail, { id: id })
                        .then(response => {
                            let t = $("form").offset().top;

                            $("html, body").animate(
                                {
                                    scrollTop: t
                                },
                                500
                            );

                            this.$parent.$emit("openForm", true);
                            this.$parent.$emit("edit", response.data);
                        })
                        .catch(error => {});
                }.bind(this)
            );

            $("#current_table tbody").on(
                "click",
                ".delete",
                function(event) {
                    let row = $(event.target).parents("tr");
                    if (row.hasClass("child")) row = row.prev();
                    let id = this.datatable.row(row).data().id;
                    let data = {
                        type: 4,
                        title: "¿Estás seguro?",
                        msg: "Estás seguro de cambiar el estado del usuario",
                        url: this.urlDelete,
                        id: id
                    };

                    this.$parent.alertMsg(data);
                }.bind(this)
            );
        }
    }
};
</script>