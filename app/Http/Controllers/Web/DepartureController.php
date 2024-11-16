<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartureController extends Controller
{
    public function index(){
        return view('backend.departure.home');
    }

    public function getTotalRecaudadoFechaRango(Request $request){
        $selectAnio = $request->input('selectAnio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                    COALESCE(FORMAT(SUM(cpd.monto_neto), 'C', 'es-PE'), 'S/ 0.00') as sub_total from caja.partida_diaria cpd 
                    inner join caja.partida cp on cp.partida_id=cpd.partida_id 
                    where  
                    --year(cpd.fecha_partida)=$selectAnio and
                     convert(date,cpd.fecha_partida)>='$fechaInicio' 
                    and  convert(date,cpd.fecha_partida)<='$fechaFin' ");
            return response()->json([
                'status'=>true,
                'res'=>$res
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'res'=>''
            ]);
        }
    }

    public function getTotalIngresoPartida(Request $request){
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        try {
            $res = DB::select("SET NOCOUNT ON; EXEC siget.usp_reporte_partida_5_copia_reporte_gerencial ?, ?", [$fechaInicio,$fechaFin]);
            return response()->json([
                'status'=>true,
                'res'=>$res
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'res'=>''
            ]);
        }
    }

    public function getTopCincoPartidasRecaudados(Request $request){
        $selectAnio = $request->input('selectAnio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        top(5) cp.partida_id, cp.descripcion as descrip, SUM(cpd.monto_neto) as sub_total from caja.partida_diaria cpd 
                    inner join caja.partida cp on cp.partida_id=cpd.partida_id 
                    inner join mante.mes m on m.id=month(cpd.fecha_partida) 
                    where  
                    --year(cpd.fecha_partida)=$selectAnio and
                     convert(date,cpd.fecha_partida)>='$fechaInicio' 
                    and convert(date,cpd.fecha_partida)<='$fechaFin'
                    group by cp.partida_id, cp.descripcion
                    order by SUM(cpd.monto_neto) desc ");
            return response()->json([
                'status'=>true,
                'res'=>$res
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'res'=>''
            ]);
        }
    }

    public function getTotalIngresoPartidaDetallado(Request $request){
        $selectAnio = $request->input('selectAnio');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        cp.partida_id, cp.descripcion as descrip, SUM(cpd.monto_neto) as sub_total from caja.partida_diaria cpd 
                    inner join caja.partida cp on cp.partida_id=cpd.partida_id 
                    inner join mante.mes m on m.id=month(cpd.fecha_partida) 
                    where  
                    -- year(cpd.fecha_partida)=$selectAnio and
                     convert(date,cpd.fecha_partida)>='$fechaInicio' 
                    and convert(date,cpd.fecha_partida)<='$fechaFin'
                    group by cp.partida_id, cp.descripcion
                    order by cp.partida_id asc ");
            return response()->json([
                'status'=>true,
                'res'=>$res
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'res'=>''
            ]);
        }
    }
}
