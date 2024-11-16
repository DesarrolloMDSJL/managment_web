<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Mes;
use App\Models\PagoTupa;
use App\Models\Tupa;
use App\Models\TupaPeriodo;
use App\Models\Unidad;

class DashboardController extends Controller
{
    public function index(){
        return view('backend.dashboard.home');
    }
   
    public function percentageTotal(Request $request){
        $anio =$request->input('selectAnio');
        $totalTupaTusne = DB::connection('sqlsrv')
            ->select("
                SELECT SUM(cpt.monto_pago) as sub_total
                FROM mante.mes mante
                LEFT JOIN caja.pago_tupa cpt ON mante.id = MONTH(cpt.fecha_pago)
                LEFT JOIN caja.tupa ct ON cpt.tupa_id = ct.tupa_id
                LEFT JOIN caja.tupa_periodo ctp ON ctp.tupa_id = ct.tupa_id
                LEFT JOIN mante.unidad u ON u.unidad_id = ct.unidad_id
                WHERE ctp.periodo = '$anio'
                AND cpt.flag_extorno = 0
                AND YEAR(cpt.fecha_pago) = '$anio'
                AND ct.estado = 1
                AND u.estado = 1 ");

        $totalMultas = DB::connection('sqlsrv')
            ->select("
            select SUM(cpd.monto_neto) as sub_total 
            from caja.partida_diaria cpd With (nolock)
            inner join caja.partida cp With (nolock) on cp.partida_id=cpd.partida_id
            where  year(cpd.fecha_partida)='$anio' and cp.partida_id in (293,290) 
            and cpd.tupa_id is null");  

        $totalTributaria = DB::connection('sqlsrv')
            ->select("
            select SUM(cpd.monto_neto) as sub_total from caja.partida_diaria cpd With (nolock)
            inner join caja.partida cp With (nolock) on cp.partida_id=cpd.partida_id
            where  year(cpd.fecha_partida)='$anio' and cp.partida_id in (185,180,192,189,172,173,175,308,280,307,277,278,304) 
            and cpd.tupa_id is null");        
            $totalSuma = $totalTupaTusne[0]->sub_total + $totalMultas[0]->sub_total + $totalTributaria[0]->sub_total;

            // Formatear los totales
            $totalTupaTusneFormat = number_format($totalTupaTusne[0]->sub_total, 2, '.', ',');
            $totalMultasFormat = number_format($totalMultas[0]->sub_total, 2, '.', ',');
            $totalTributariaFormat = number_format($totalTributaria[0]->sub_total, 2, '.', ',');
            $totalFormat = number_format($totalSuma, 2, '.', '');
            
            // Calcular porcentajes
            $porcentaje1 = ($totalTupaTusne[0]->sub_total / $totalSuma) * 100;
            $porcentaje2 = ($totalMultas[0]->sub_total / $totalSuma) * 100;
            $porcentaje3 = ($totalTributaria[0]->sub_total / $totalSuma) * 100;
            
            // Formatear porcentajes
            $porcentaje1Format = number_format($porcentaje1, 2, '.', ',');
            $porcentaje2Format = number_format($porcentaje2, 2, '.', ',');
            $porcentaje3Format = number_format($porcentaje3, 2, '.', ',');
      
        return response()->json([
            'totalTupaTusne'=>$totalTupaTusneFormat,
            'porcentaje1'=>round($porcentaje1Format,2),
            'totalMultas'=>$totalMultasFormat,
            'porcentaje2'=>round($porcentaje2Format,2),
            'totalTributaria'=>$totalTributariaFormat,
            'porcentaje3'=>round($porcentaje3Format,2),
            'total'=>number_format($totalSuma, 2, '.', ',')
        ],200);    
    }

    public function getMes(Request $request){
        $selectAnio = $request->input('selectAnio');
        $res = Mes::where('anno',$selectAnio)->get();
        try {
            if(count($res) > 0){
                return response()->json([
                    'status'=>true,
                    'res'=>$res
                ],200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'res'=>$th
            ],200);
        }
    }

    public function getTotalIngresoMesTupaTusne(Request $request){
        $anio = $request->input('selectAnio');
        try {
            $res = DB::connection('sqlsrv')
                ->select("SELECT mante.id , UPPER(mante.mes) AS mes, SUM(cpt.monto_pago) as sub_total FROM mante.mes mante With (nolock)
                LEFT JOIN caja.pago_tupa cpt With (nolock) on mante.id=month(cpt.fecha_pago)
                LEFT JOIN caja.tupa ct With (nolock) ON cpt.tupa_id=ct.tupa_id
                LEFT JOIN caja.tupa_periodo ctp With (nolock) ON ctp.tupa_id=ct.tupa_id
                LEFT JOIN mante.unidad u With (nolock) ON u.unidad_id=ct.unidad_id
                WHERE (ctp.periodo='$anio') AND (cpt.flag_extorno=0) 
                AND YEAR(cpt.fecha_pago) = '$anio'
                AND (ct.estado=1) AND u.estado=1
                GROUP BY mante.id , mante.mes order by mante.id asc");
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

    public function getTopTotalRecaudacionArea(Request $request){
        $anio = $request->input('selectAnio');
        $mes = $request->input('selectMes');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT TOP (5) REPLACE(REPLACE(u.descripcion, 'subgerencia', ''), ' DE ', '') AS descripcion, SUM(cpt.monto_pago) AS total
                    FROM caja.pago_tupa cpt With (nolock)
                    LEFT JOIN caja.tupa ct With (nolock) ON cpt.tupa_id = ct.tupa_id
                    LEFT JOIN caja.tupa_periodo ctp With (nolock) ON ctp.tupa_id = ct.tupa_id
                    LEFT JOIN mante.unidad u With (nolock) ON u.unidad_id = ct.unidad_id
                    WHERE ctp.periodo = '$anio' 
                        AND YEAR(cpt.fecha_pago) = '$anio' 
                        AND cpt.flag_extorno = 0 
                        AND ct.estado = 1
                        AND u.estado = 1
                        AND MONTH(cpt.fecha_pago) = '$mes'
                    GROUP BY REPLACE(REPLACE(u.descripcion, 'subgerencia', ''), ' DE ', '')
                    ORDER BY total DESC");
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

    public function getTotalIngresoMesMultas(Request $request){
        $anio = $request->input('selectAnio');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT mante.id, UPPER(mante.mes) AS mes,SUM(cpd.monto_neto) as sub_total from caja.partida_diaria cpd With (nolock)
                    inner join caja.partida cp With (nolock) on cp.partida_id=cpd.partida_id
                    LEFT JOIN mante.mes mante on mante.id=month(cpd.fecha_partida)
                    where  year(cpd.fecha_partida)='$anio' and cp.partida_id in (293,290) and cpd.tupa_id is null
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

    public function getTotalRecaudacionMesMultas(Request $request){
        $anio = $request->input('selectAnio');
        $mes = $request->input('selectMes');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT TOP(5) REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(u.descripcion, 'LICENCIAS Y AUTORIZACIONES', 'LIC. Y AUTORIZ.'), 'TRANSPORTE DE VEHÍCULOS MENORES', 'TRANS.DE VEH. MENO.'), 'PRESERVACION DEL MEDIO AMBIENTE Y ORNATO', 'PRES. M.AMBIEN. Y ORNAT.'), 'RESPETO A LA NORMA MUNICIPAL', 'RESP.A LA NOR.MUNIC.') , 'SEGURIDAD', 'SEG.'), 'DESARROLLO URBANO', 'DESARR. URBA.'), 'SALUBRIDAD', 'SALUBR.') as mes, SUM(d.monto_neto) as sub_total FROM caja.partida_diaria d 
                    inner join mante.subconcepto s on s.subconcepto_id=d.subconcepto_id 
                    inner join mante.unidad_ras u on u.id=s.unidad_id
                    WHERE YEAR(d.fecha_partida) = '$anio' and d.partida_id in (293,290) and month(d.fecha_partida)='$mes' and d.tupa_id is null
                    group by u.descripcion order by sub_total desc");
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
    public function getTotalIngresoMesTributaria(Request $request){
        $anio = $request->input('selectAnio');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT  m.mes as mes, sum(cpd.monto_neto) as sub_total from caja.partida_diaria cpd 
                    inner join caja.partida cp on cp.partida_id=cpd.partida_id 
                    inner join mante.mes m on m.id=month(cpd.fecha_partida)
                    where  year(cpd.fecha_partida)='$anio' and cp.partida_id in (185,180,192,189,172,173,175,308,280,307,277,278,304) and cpd.tupa_id is null
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
    public function getTotalRecaudacionMesTributaria(Request $request){
        $anio = $request->input('selectAnio');
        $mes = $request->input('selectMes');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT  TOP(5) REPLACE(REPLACE(REPLACE(REPLACE(cp.descripcion, 'IMPUESTO A LOS ESPECTACULOS PUBLICOS NO DEPORTIVOS', 'IMP.ESPEC. PUB. NO DEPOR.'), 'INGRESOS POR COSTAS PROCESALES', 'INGRE. COSTAS PROCES.'), 'PREDIAL - REGULARIZACIÓN TRIBUTARIA', 'PRED. -REGULAR. TRIB.'),'FRACCIONAMIENTO TRIBUTARIO REGULAR', ' FRACC. TRIB.REG.') as mes ,sum(cpd.monto_neto) as sub_total from caja.partida_diaria cpd 
                    inner join caja.partida cp on cp.partida_id=cpd.partida_id 
                    where  year(cpd.fecha_partida)='$anio' and MONTH(cpd.fecha_partida)='$mes' and cp.partida_id in (185,180,192,189,172,173,175,308,280,307,277,278,304) and cpd.tupa_id is null
                    group by cp.descripcion
                    order by sub_total desc");
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


    public function getAnno(){
        try {
        $res = DB::connection('sqlsrv')
            ->select("SELECT  mes.anno FROM mante.mes GROUP BY  mes.anno");
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