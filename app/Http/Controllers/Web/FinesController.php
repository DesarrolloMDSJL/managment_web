<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinesController extends Controller
{
    public function index(){
        return view('backend.fines.home');
    }

    public function getCuisRas(){
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT id, descripcion FROM mante.unidad_ras where estado=1 and id>=6");
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
    public function getTotalRecaudadoCuisRas(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectCuisRas = $request->input('selectCuisRas');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        COALESCE(FORMAT(SUM(cpd.monto_neto), 'C', 'es-PE'), 'S/ 0.00') as sub_total
                    from caja.partida_diaria cpd With (nolock)
                    inner join mante.subconcepto s With (nolock) on s.subconcepto_id=cpd.subconcepto_id 
                    inner join mante.unidad_ras u With (nolock) on u.id=s.unidad_id
                    where  year(cpd.fecha_partida)=$selectAnio and cpd.partida_id in (293, 290) and cpd.tupa_id is null and u.id=$selectCuisRas");
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
    public function getTotalRecaudadoMesCuisRas(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectMes = $request->input('selectMes');
        $selectCuisRas = $request->input('selectCuisRas');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT
                        COALESCE(FORMAT(SUM(cpd.monto_neto), 'C', 'es-PE'), 'S/ 0.00') as sub_total 
                    from caja.partida_diaria cpd With (nolock)
                    inner join mante.subconcepto s With (nolock) on s.subconcepto_id=cpd.subconcepto_id 
                    inner join mante.unidad_ras u With (nolock) on u.id=s.unidad_id where year(cpd.fecha_partida)=$selectAnio 
                    and cpd.partida_id in (293,290) and cpd.tupa_id is null 
                    and month(cpd.fecha_partida)=$selectMes and u.id= $selectCuisRas");
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
    public function getIngresoMesCuisRas(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectCuisRas = $request->input('selectCuisRas');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        mante.id, mante.mes AS mes,SUM(cpd.monto_neto) as sub_total from caja.partida_diaria cpd With (nolock)
                    LEFT JOIN mante.mes mante on mante.id=month(cpd.fecha_partida)
                    inner join mante.subconcepto s With (nolock) on s.subconcepto_id=cpd.subconcepto_id 
                    inner join mante.unidad_ras u With (nolock) on u.id=s.unidad_id
                    where  year(cpd.fecha_partida)=$selectAnio 
                    and cpd.partida_id in (293, 290) 
                    and cpd.tupa_id is null 
                    and u.id=$selectCuisRas
                    group by mante.id, mante.mes order by mante.id asc");
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
    public function getRecorridoDiaCuisRas(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectMes = $request->input('selectMes');
        $selectCuisRas = $request->input('selectCuisRas');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        CONCAT(DAY(cpd.fecha_partida), '/', MONTH(cpd.fecha_partida)) AS mes, ISNULL(SUM(cpd.monto_neto), 0.0) as sub_total from caja.partida_diaria cpd With (nolock)
                    inner JOIN mante.subconcepto s With (nolock) on s.subconcepto_id=cpd.subconcepto_id 
                    inner JOIN mante.unidad_ras u With (nolock) on u.id=s.unidad_id
                    WHERE cpd.partida_id in (293,290)
                    and cpd.tupa_id is null 
                    and u.id=$selectCuisRas
                    and month(cpd.fecha_partida)=$selectMes
                    and year(cpd.fecha_partida)=$selectAnio
                    GROUP BY  day(cpd.fecha_partida), month(cpd.fecha_partida), year(cpd.fecha_partida)
                    order  by  month(cpd.fecha_partida), day(cpd.fecha_partida) asc");
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

    public function getListCuisRas(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectMes = $request->input('selectMes');
        $selectCuisRas = $request->input('selectCuisRas');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        s.descripcion, COALESCE(FORMAT(SUM(d.monto_neto), 'C', 'es-PE'), 'S/ 0.00') as sub_total, SUM(d.monto_neto) as total
                    FROM caja.partida_diaria d  With (nolock)
                                inner join mante.subconcepto s With (nolock) on s.subconcepto_id=d.subconcepto_id 
                                inner join mante.unidad_ras u With (nolock) on u.id=s.unidad_id
                    where d.partida_id in (293, 290)
                    and d.tupa_id is null
                    and u.id=$selectCuisRas 
                    and month(d.fecha_partida)= $selectMes 
                    and YEAR(d.fecha_partida)=$selectAnio
                    group by s.descripcion");
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
