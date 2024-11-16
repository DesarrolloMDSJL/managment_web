<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index(){
        return view('backend.login');
    }

    public function login(Request $request){
        $userName = $request->input('userName');
        $password = $request->input('password');
        $userData = User::where('nombre_usuario',$userName)
                        ->join('mante.unidad','unidad.unidad_id','=','seguridad.usuario.unidad_id')
                        ->whereRaw("CONVERT(VARCHAR(300), DECRYPTBYPASSPHRASE('gisjl', password)) = '$password'")
                        ->select('seguridad.usuario.apellidos',
                                 'seguridad.usuario.nombres',
                                 'seguridad.usuario.usuario_id as usu_id',
                                 'mante.unidad.unidad_id',
                                 'mante.unidad.descripcion'
                        )
                        ->first();  
       if($userData){
            $rolUserData = DB::connection('sqlsrv')
                            ->select("SELECT
                                    r.rol_id,
                                    r.descripcion_corta,
                                    r.descripcion as nombre,
                                    u.usuario_id 
                                    from seguridad.rol_usuario ru
                                    inner join seguridad.rol r on  ru.rol_id =  r.rol_id 
                                    inner join seguridad.usuario u on ru.usuario_id  = u.usuario_id 
                                    where u.usuario_id = ".$userData->usu_id."
                                    and r.rol_id in(22,23) and ru.estado=1 ");             
                    session(['auth'=>true,'userData' => $userData,'rolUserData' => $rolUserData]);
            return response()->json([
                'status'=>true,
                'user'=>$userData,
                'rolUserData'=>$rolUserData
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'user'=>''
            ],400);
        } 
    }

    public function logout(){
        session()->forget('userData');
        session()->forget('rolUserData');
        session()->forget('auth');
        return redirect('/');
    }
}

