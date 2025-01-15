<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){
        return view('backend.report.home');
    }

    public function getUnidadOrganica(){
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT unidad_id, descripcion FROM mante.unidad where estado=1");
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

    public function getTotalRecaudadoUnidadOrganica(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectArea = $request->input('selectArea');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        COALESCE(FORMAT(SUM(cpt.monto_pago), 'C', 'es-PE'), 'S/ 0.00') as sub_total
                    FROM mante.mes mante 
                    LEFT JOIN caja.pago_tupa cpt on mante.id=month(cpt.fecha_pago)
                    LEFT JOIN caja.tupa ct ON cpt.tupa_id=ct.tupa_id
                    LEFT JOIN caja.tupa_periodo ctp ON ctp.tupa_id=ct.tupa_id
                    LEFT JOIN mante.unidad u  ON   u.unidad_id=ct.unidad_id
                    WHERE (ctp.periodo=$selectAnio) AND (cpt.flag_extorno=0) 
                    AND YEAR(cpt.fecha_pago) = $selectAnio AND u.unidad_id=$selectArea
                    --AND (ct.estado=1) AND u.estado=1
                    ");
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

    public function getIngresoMesUnidadOrganica(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectArea = $request->input('selectArea');
        $selectMes = $request->input('selectMes');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        COALESCE(FORMAT(SUM(cpt.monto_pago), 'C', 'es-PE'), 'S/ 0.00') as sub_total
                    from  caja.tupa ct
                    inner join caja.tupa_periodo ctp on ctp.tupa_id=ct.tupa_id
                    inner join caja.pago_tupa cpt on cpt.tupa_id=ct.tupa_id 
                    inner join mante.mes m on m.id=MONTH(cpt.fecha_pago) 
                    where ctp.periodo=$selectAnio 
                    and cpt.flag_extorno=0 
                    and m.id=$selectMes
                    and YEAR(cpt.fecha_pago)=$selectAnio and unidad_id= $selectArea");
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

    public function getTotalRecaudadoMesUnidadOrganica(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectArea = $request->input('selectArea');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT  
                        mante.id , mante.mes AS mes,  SUM(cpt.monto_pago) as sub_total 
                    FROM mante.mes mante With (nolock)
                    LEFT JOIN caja.pago_tupa cpt With (nolock) on mante.id=month(cpt.fecha_pago)
                    LEFT JOIN caja.tupa ct With (nolock) ON cpt.tupa_id=ct.tupa_id
                    LEFT JOIN caja.tupa_periodo ctp With (nolock) ON ctp.tupa_id=ct.tupa_id
                    LEFT JOIN mante.unidad u With (nolock) ON u.unidad_id=ct.unidad_id
                    WHERE (ctp.periodo=$selectAnio) AND (cpt.flag_extorno=0) 
                    AND YEAR(cpt.fecha_pago) = $selectAnio and u.unidad_id=$selectArea 
                    AND (ct.estado=1) AND u.estado=1
                    GROUP BY mante.id, mante.mes order by mante.id asc");
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

    public function getRecorridoDiarioMesUnidadOrganica(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectArea = $request->input('selectArea');
        $selectMes = $request->input('selectMes');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        CONCAT(DAY(cpt.fecha_pago), '/', MONTH(cpt.fecha_pago)) AS dia_mes, ISNULL(SUM(cpt.monto_pago), 0.0) as sub_total 
                    FROM  caja.pago_tupa cpt With (nolock)
                    LEFT JOIN caja.tupa ct With (nolock) ON cpt.tupa_id=ct.tupa_id
                    LEFT JOIN caja.tupa_periodo ctp With (nolock) ON ctp.tupa_id=ct.tupa_id
                    LEFT JOIN mante.unidad u With (nolock) ON   u.unidad_id=ct.unidad_id
                    WHERE (ctp.periodo=$selectAnio OR ctp.periodo IS NULL) 
                    AND (cpt.flag_extorno=0 OR cpt.flag_extorno IS NULL) 
                    AND year(cpt.fecha_pago)=$selectAnio     
                    AND month(cpt.fecha_pago) = $selectMes
                    AND (ct.estado=1 OR ct.estado IS NULL) 
                    and u.unidad_id=$selectArea
                    GROUP BY  day(cpt.fecha_pago), month(cpt.fecha_pago)
                    order  by  month(cpt.fecha_pago), day(cpt.fecha_pago) asc");
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

    public function getReporteTupaMesUnidadOrganica(Request $request){
        $selectAnio = $request->input('selectAnio');
        $selectArea = $request->input('selectArea');
        $selectMes = $request->input('selectMes');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT 
                        top (500) cpt.tupa_id, ct.descripcion, SUM(cpt.cantidad) as cantidad, ctp.tasa as unitario, FORMAT(SUM(cpt.monto_pago), 'C', 'es-PE') as sub_total, SUM(cpt.monto_pago) as total
                    from  caja.tupa ct
                    inner join caja.tupa_periodo ctp on ctp.tupa_id=ct.tupa_id
                    inner join caja.pago_tupa cpt on cpt.tupa_id=ct.tupa_id 
                    inner join mante.mes m on m.id=MONTH(cpt.fecha_pago)
                    where ctp.periodo=$selectAnio 
                    and cpt.flag_extorno=0 
                    and unidad_id=$selectArea
                    and ct.estado=1
                    and m.id=$selectMes
                    and YEAR(cpt.fecha_pago)=$selectAnio
                    group by cpt.tupa_id, ct.descripcion, ctp.tasa 
                    order by cpt.tupa_id");
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
