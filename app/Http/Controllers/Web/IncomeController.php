<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use App\Exports\ReportePresupuestoAreaExport;
use Maatwebsite\Excel\Facades\Excel;

class IncomeController extends Controller
{
    public function index(){
        return view('backend.income.home');
    }

    public function getTotalRecaudado(Request $request){
        $anio = $request->input('selectAnio');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT COALESCE(FORMAT(SUM(cpd.monto_neto), 'C', 'es-PE'), 'S/ 0.00') as sub_total from caja.partida_diaria cpd 
                    inner join caja.partida cp on cp.partida_id=cpd.partida_id where  year(cpd.fecha_partida)='$anio' ");
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

    public function getTotalIngresoMes(Request $request){
        $anio = $request->input('selectAnio');
        $mes = $request->input('selectMes');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT COALESCE(FORMAT(SUM(cpd.monto_neto), 'C', 'es-PE'), 'S/ 0.00') as sub_total from caja.partida_diaria cpd 
            inner join caja.partida cp on cp.partida_id=cpd.partida_id where  year(cpd.fecha_partida)='$anio' and month(cpd.fecha_partida)='$mes'");
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

    public function getIngresoPartidaGeneral(Request $request){
        $anio = $request->input('selectAnio');
        $mes =  $request->input('selectMes');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT id, n_mes, mes, cast(fecha_inicio as date) as fecha_inicio, cast(fecha_fin as date) as fecha_fin FROM mante.mes WHERE n_mes=$mes and anno= $anio");
            $fecha_inicio=$res[0]->fecha_inicio;
            $fecha_fin=$res[0]->fecha_fin;
            $exec = DB::select("SET NOCOUNT ON; EXEC siget.usp_reporte_partida_5_copia_reporte_gerencial ?, ?", [$fecha_inicio, $fecha_fin]);
            return response()->json([
                'status'=>true,
                'res'=>$exec
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'res'=>''
            ]);
        }
    }

    public function getIngresoPartidaDetallado(Request $request){
        $anio = $request->input('selectAnio');
        $mes =  $request->input('selectMes');
        $id_partida =  $request->input('id_partida');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT id, n_mes, mes, cast(fecha_inicio as date) as fecha_inicio, cast(fecha_fin as date) as fecha_fin FROM mante.mes WHERE n_mes=$mes and anno= $anio");
            $fecha_inicio=$res[0]->fecha_inicio;
            $fecha_fin=$res[0]->fecha_fin;
            $exec = DB::select("SET NOCOUNT ON; EXEC siget.usp_top_6_partida_detallado_copia_reporte_gerencial ?, ?, ?, ?", [$id_partida,$fecha_inicio, $fecha_fin,1]);
            return response()->json([
                'status'=>true,
                'res'=>$exec
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'res'=>''
            ]);
        }
    }

    public function getReportePartidaDetallado(Request $request){
        $anio = $request->input('selectAnio');
        $mes =  $request->input('selectMes');
        $id_partida =  $request->input('id_partida');
        try {
            $res = DB::connection('sqlsrv')
            ->select("SELECT id, n_mes, mes, cast(fecha_inicio as date) as fecha_inicio, cast(fecha_fin as date) as fecha_fin FROM mante.mes WHERE n_mes=$mes and anno= $anio");
            $fecha_inicio=$res[0]->fecha_inicio;
            $fecha_fin=$res[0]->fecha_fin;
            $exec = DB::select("SET NOCOUNT ON; EXEC siget.usp_reporte_partida_detallado_5_copia_reporte_gerencial ?, ?, ?, ?", [$id_partida,$fecha_inicio, $fecha_fin,1]);
            return response()->json([
                'status'=>true,
                'res'=>$exec
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'res'=>''
            ]);
        }
    }

    public function getReportePresupuestoArea(Request $request){
        $date_start = $request->input('date_start');
        $date_start = date('Y-m-d', strtotime($date_start));

        $date_finish = $request->input('date_finish');
        $date_finish = date('Y-m-d', strtotime($date_finish));
        try {
            return Excel::download(new ReportePresupuestoAreaExport( $date_start, $date_finish), 'reporte_presupuesto_por_area.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
