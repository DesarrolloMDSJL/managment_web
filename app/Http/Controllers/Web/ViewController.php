<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Area;
use Auth;
use App\Traits\ConvertionMethods;

class ViewController extends Controller
{
    /* use ConvertionMethods;
    protected $menus;
    protected $show_import; */

    /* public function __construct(){

        $this->show_import = false;
    } */
    public function login(){
        return view('backend.login');
    } 

    public function store(Request $request)
    {
        $usuario = $request->input('usuario');
        $contra = $request->input('contra');

        // Realiza una consulta para verificar las credenciales del usuario en la base de datos
        $userData = DB::connection('sqlsrv')
            ->table('seguridad.usuario')
            ->where('nombre_usuario', $usuario)
            ->whereRaw("CONVERT(VARCHAR(300), DECRYPTBYPASSPHRASE('gisjl', password)) = '$contra'")
            ->first();

        if ($userData) {
            session(['userData' => $userData]);

            return redirect('/dashboard');
        } else {
            return view('brix.index')->with('message', 'Credenciales Incorrectas');
        }
    }
    
    /* public function dashboard(){
        $menus =  $this->userNavbar(Auth::user()->id);
        $show_import = $this->show_import;
        return view('backend.dashboard',compact('menus','show_import'));
    } */
}
