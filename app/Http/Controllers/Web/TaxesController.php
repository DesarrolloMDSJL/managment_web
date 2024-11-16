<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxesController extends Controller
{
    public function index(){
        return view('backend.taxes.home');
    }

    public function getTributo(){
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                    partida_id, descripcion 
                    from caja.partida 
                    where partida_id in (172,173,175,180,277,278 ,280 ,307,308,304)");
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

    public function getTotalRecaudadoTributo(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectTributo = $request->input('selectTributo');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        COALESCE(FORMAT(SUM(cpd.monto_neto), 'C', 'es-PE'), 'S/ 0.00') as sub_total 
                    from caja.partida_diaria cpd With (nolock)
                    where  year(cpd.fecha_partida)=$selectAnio
                    and cpd.tupa_id is null
                    and cpd.partida_id=$selectTributo");
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

    public function getTotalRecaudadoMesTributo(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectMes = $request->input('selectMes');
        $selectTributo = $request->input('selectTributo');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        COALESCE(FORMAT(SUM(cpd.monto_neto), 'C', 'es-PE'), 'S/ 0.00') as sub_total 
                    from caja.partida_diaria cpd With (nolock)
                    where year(cpd.fecha_partida)=$selectAnio 
                    and cpd.tupa_id is null 
                    and month(cpd.fecha_partida)=$selectMes
                    and cpd.partida_id=$selectTributo");
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

    public function getIngresoMesTributo(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectTributo = $request->input('selectTributo');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT m.id, m.mes as mes, sum(cpd.monto_neto) as sub_total
                    from caja.partida_diaria cpd 
                    inner join caja.partida cp on cp.partida_id=cpd.partida_id 
                    inner join mante.mes m on m.id=month(cpd.fecha_partida)
                    where  year(cpd.fecha_partida)=$selectAnio 
                    and cp.partida_id=$selectTributo
                    and cpd.tupa_id is null
                    group by m.id, m.mes
                    order by m.id asc");
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

    public function getRecorridoDiaTributo(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectMes = $request->input('selectMes');
        $selectTributo = $request->input('selectTributo');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        CONCAT(DAY(cpd.fecha_partida), '/', MONTH(cpd.fecha_partida)) AS mes, ISNULL(SUM(cpd.monto_neto), 0.0) as sub_total 
                    from caja.partida_diaria cpd With (nolock)
                    WHERE cpd.partida_id=$selectTributo 
                    and cpd.tupa_id is null and month(cpd.fecha_partida)=$selectMes
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

    public function getListTributo(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectMes = $request->input('selectMes');
        $selectTributo = $request->input('selectTributo');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT s.descripcion, COALESCE(FORMAT(SUM(d.monto_neto), 'C', 'es-PE'), 'S/ 0.00') as sub_total, SUM(d.monto_neto) as total
                    FROM caja.partida_diaria d  With (nolock)
                    inner join mante.subconcepto s With (nolock) on s.subconcepto_id=d.subconcepto_id 
                    where d.tupa_id is null
                    and d.partida_id=$selectTributo
                    and month(d.fecha_partida)=$selectMes
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
