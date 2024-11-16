<template>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Usuario</h4>
        </div>
        <div class="card-body">               
            <form class="form" @submit.prevent="$parent.formController(route,$event,null)">
                 <input type="hidden" v-if="model != undefined" name="id" :value="model.id">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Nombres</label>
                                    <input type="text" class="form-control" id="name" name="name"  autocomplete="off" v-model="model.name" placeholder="Usuario" />
                                    <div class="invalid-feedback name-error errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Apellidos</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"  autocomplete="off" v-model="model.lastname" placeholder="Usuario" />
                                    <div class="invalid-feedback lastname-error errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Documento</label>
                                    <input type="text" class="form-control" id="document" name="document"  autocomplete="off"  v-model="model.dni" placeholder="Dni" />
                                    <div class="invalid-feedback document-error errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password"  autocomplete="off" v-model="model.password" placeholder="Contraseña" />
                                    <div class="invalid-feedback password-error errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                <label for="helpInputTop">Area</label>
                                    <select 
                                            id="areaId"
                                            name="areaId" 
                                            v-model="model.areaId"
                                            class="form-control"
                                        >
                                            <option value="">Seleccione una area</option>
                                            <option :value="item.id" v-for="item in areas">{{item.name}}</option>
                                        
                                        </select>
                                        <div class="invalid-feedback status-error errors"></div>
                                </div>
                            </div> 
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                <label for="helpInputTop">Rol</label>
                                    <select 
                                            id="role"
                                            name="role" 
                                            v-model="model.role"
                                            class="form-control"
                                        >
                                            <option value="">Seleccione un rol</option>
                                            <option value="F">Fedatario</option>
                                            <option value="A">Administrador</option>
                                        
                                        </select>
                                        <div class="invalid-feedback role-error errors"></div>
                                </div>
                            </div> 
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                <label for="helpInputTop">Estado</label>
                                    <select 
                                            id="isActive"
                                            name="isActive" 
                                            v-model="model.isActive"
                                            class="form-control"
                                        >                                           
                                            <option value="0">Inhabilitado</option>
                                            <option value="1">Habilitado</option>
                                        
                                        </select>
                                        <div class="invalid-feedback role-error errors"></div>
                                </div>
                            </div> 
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Firma</label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        name="file"
                                        id="file"
                                        aria-describedby="fileHelp"
                                        autocomplete="off"
                                    />
                                    <div
                                        class="invalid-feedback file-error errors"
                                    ></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1" v-if="!edit">Registrar</button>
                                <button type="submit"  class="btn btn-primary mr-1"  v-if="edit">Actualizar</button>
                                <button type="button" class="btn btn-outline-secondary" @click="clearModel">Cancelar</button>
                            </div>   
                        </div>
                    </div>                   
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    props : {
        route: {
            type: String,
            default: ''
        },       
        areas : {
            type: Array,
            default: []
        },
      
    },
    data() {
        return {
            model: {
                id: null,                  
                name: "",
                lastname: "",   
                areaId: "",
                role: "",
                isActive:"1",
                password: ""   ,                                   
              
            },        
            edit: false,   
        }
    },
    components: {
    },
    computed:{
      
    },
    mounted() {    
     
        this.$parent.$on('edit', function(data) {
          
          
                     
            this.model = user     
          
            this.edit = true;
        
            this.$parent.clearErrors();

          
        }.bind(this));

        this.$parent.$on('clear',this.clearModel);
    },
    methods : {
        
        clearModel: function()
        {           
            this.model = {
                id: null,                   
                name: "",
                lastname: "",   
                areaId: "",
                role: "",
                isActive:"1",
                password: ""   ,  
            };           
         
            this.edit = false;
          
        },       
    },
}
</script>