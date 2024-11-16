<template>
     <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5" style="background: #34A0B3;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                <div class="logo" style="width: 100%; display: flex; justify-content: center; flex-direction: column; align-items: center; padding: 5% 5% 10% 5%">
                    <!-- <img :src="iconLogo" alt="Municipalidad San Juan de Lurigancho" style="width: 200px; border-radius: 5px;"> -->
                    <h4 class="card-title mb-1 text-white text-bien">Bienvenido</h4>
                    <h3 class="card-title mb-1 text-white text-center mt-1" style="font-weight: 900;
    font-family: system-ui;
    font-size: 2rem;"   >INICIA SESIÓN</h3>
                </div>
                <p class="card-text mb-2 text-white">Por favor ingrese sus credenciales para poder acceder a los reportes gerenciales</p>
                <form class="auth-login-form mt-2" @submit.prevent="login">
                    <div class="form-group">
                        <label class="form-label text-white" for="login-email">Usuario</label>
                        <input class="form-control" id="login-email" type="text" name="document" placeholder="12345678" aria-describedby="login-email" autofocus="" tabindex="1" v-model="userName"/>
                        <span style="color:red" v-show="errorMessage.messageUserName!==''">{{  errorMessage.messageUserName}}</span>
                    </div>
                    <div class="form-group">
                        <label for="login-password" class="text-white">Password</label>
                        <input class="form-control" id="login-password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" v-model="password"/>                        
                        <span style="color:red" v-show="errorMessage.messagePassword!==''">{{  errorMessage.messagePassword}}</span>
                    </div>                   
                    <span class="text-danger text-center mb-1" v-show="errorMessage.messageLogin!==''">{{ errorMessage.messageLogin }}</span>
                    <button class="btn btn-block" tabindex="4"  type="submit"  style="border-color: #ff9f43 !important;background-color: #ff9f43 !important;color: #fff !important;">{{ error ? 'Ingresando...':'Ingresar' }}</button>
                </form>            
            </div>
        </div>
</template>
<script>
    import axios from 'axios';
    export default {
        props:{
            url:{
                type:String,
                default:'',
            },
            dashboard:{
                type:String,
                default:'',
            },
            report:{
                type:String,
                default:'',
            },
            iconLogo:{
                type:String,
                default:'',
            }
        },
        data() {
            return {
                userName:'',//ggalvez_rg
                password:'',//123456
                error:false,
                errorMessage:{
                    messageUserName:'',
                    messagePassword:'',
                    messageLogin:'',
                },
                array:[]
            }
        },
        components: {
        },
         mounted() {
        },
        methods : {
            async login(){
                this.array = []
                let form = {
                    userName: this.userName,
                    password:this.password
                }
                this.error=true;
                if(this.userName==''){
                    this.error=false
                    this.errorMessage.messageLogin=''
                    this.errorMessage.messageUserName='El campo es requerido'
                    return;
                }else{
                    this.error=true
                    this.errorMessage.messageUserName='';
                }

                if(this.password==''){
                    this.error=false
                    this.errorMessage.messageLogin=''
                    this.errorMessage.messagePassword='El campo es requerido'
                    return;
                }else{
                    this.error=true
                    this.errorMessage.messagePassword='';
                }
              
                await axios.post(this.url, form)
                .then((response) => {
                    console.log(response)
                    if(response.data.status===true){
                        this.errorMessage.messagePassword=''
                        this.errorMessage.messagePassword=''
                        this.errorMessage.messageLogin=''
                        this.error=false
                        response.data.rolUserData.forEach(element => {
                            this.array.push(element.descripcion_corta)
                            //console.log(this.array)
                            if (this.array.includes('R22') && this.array.includes('R23')) {
                                window.location.href=this.dashboard;
                                return;
                            }
                            if (this.array.includes('R22')) {
                                window.location.href=this.dashboard;
                                return;
                            }
                            if (this.array.includes('R23')){
                                window.location.href=this.report;
                            }
                        });
                        
                    }
                })
                .catch((error)=>{
                    this.error=true
                    if(error){
                        this.error=false
                        this.errorMessage.messageLogin='Usuario o Password incorrecta';
                    }
                })
            }
        },
    }
</script>

<style scoped>
    .text-bien{
        font-weight: 900;
        font-size: 4rem;
        font-family: system-ui;
    }
</style>