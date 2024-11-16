<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ViewController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\IncomeController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\FinesController;
use App\Http\Controllers\Web\TaxesController;
use App\Http\Controllers\Web\DepartureController;
use Illuminate\Support\Facades\Validator;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'login.custom'], function () {
    Route::get('/',[AuthController::class,'index'])->name('home');
});
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/login',[AuthController::class,'login'])->name('login');

Route::group(['middleware' => 'auth.custom'], function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::post('/percentage-total',[DashboardController::class,'percentageTotal'])->name('percentage-total');
    Route::post('/select-mes',[DashboardController::class,'getMes'])->name('select-mes');
    Route::get('/select-anno',[DashboardController::class,'getAnno'])->name('select-anno');
    Route::post('/select-total-ingreso-tupa-tusne',[DashboardController::class,'getTotalIngresoMesTupaTusne'])->name('select-total-ingreso-tupa-tusne');
    Route::post('/select-top-recaudacion-area',[DashboardController::class,'getTopTotalRecaudacionArea'])->name('select-top-recaudacion-area');
    Route::post('/select-total-ingreso-mes-multas',[DashboardController::class,'getTotalIngresoMesMultas'])->name('select-total-ingreso-mes-multas');
    Route::post('/select-recaudacion-mes-multas',[DashboardController::class,'getTotalRecaudacionMesMultas'])->name('select-recaudacion-mes-multas');
    Route::post('/select-total-ingreso-mes-tributaria',[DashboardController::class,'getTotalIngresoMesTributaria'])->name('select-total-ingreso-mes-tributaria');
    Route::post('/select-recaudacion-mes-tributaria',[DashboardController::class,'getTotalRecaudacionMesTributaria'])->name('select-recaudacion-mes-tributaria');
    
    Route::get('/income',[IncomeController::class,'index'])->name('income');
    Route::post('/income-total-recaudado',[IncomeController::class,'getTotalRecaudado'])->name('income-total-recaudado');
    Route::post('/income-total-ingreso-mes',[IncomeController::class,'getTotalIngresoMes'])->name('income-total-ingreso-mes');
    Route::post('/income-ingreso-partida-general',[IncomeController::class,'getIngresoPartidaGeneral'])->name('income-ingreso-partida-general');
    Route::post('/income-total-ingreso-detallado',[IncomeController::class,'getIngresoPartidaDetallado'])->name('income-total-ingreso-detallado');
    Route::post('/income-reporte-ingreso-detallado',[IncomeController::class,'getReportePartidaDetallado'])->name('income-reporte-ingreso-detallado');
    Route::get('/income-reporte-presupuesto-area',[IncomeController::class,'getReportePresupuestoArea'])->name('income-reporte-presupuesto-area');
    
    Route::get('/report',[ReportController::class,'index'])->name('report');
    Route::get('/report-unidad-organica',[ReportController::class,'getUnidadOrganica'])->name('report-unidad-organica');
    Route::post('/report-total-recaudado-unidad-organica',[ReportController::class,'getTotalRecaudadoUnidadOrganica'])->name('report-total-recaudado-unidad-organica');
    Route::post('/report-ingreso-mes-unidad-organica',[ReportController::class,'getIngresoMesUnidadOrganica'])->name('report-ingreso-mes-unidad-organica');
    Route::post('/report-total-recaudado-mes-unidad-organica',[ReportController::class,'getTotalRecaudadoMesUnidadOrganica'])->name('report-total-recaudado-mes-unidad-organica');
    Route::post('/report-recorido-diario-mes-unidad-organica',[ReportController::class,'getRecorridoDiarioMesUnidadOrganica'])->name('report-recorido-diario-mes-unidad-organica');
    Route::post('/report-recorido-tupa-mes-unidad-organica',[ReportController::class,'getReporteTupaMesUnidadOrganica'])->name('report-recorido-tupa-mes-unidad-organica');
    
    Route::get('/fines',[FinesController::class,'index'])->name('fines');
    Route::get('/fines-cuis-ras',[FinesController::class,'getCuisRas'])->name('fines-cuis-ras');
    Route::post('/fines-total-recaudado-cuis-ras',[FinesController::class,'getTotalRecaudadoCuisRas'])->name('fines-total-recaudado-cuis-ras');
    Route::post('/fines-total-recaudado-mes-cuis-ras',[FinesController::class,'getTotalRecaudadoMesCuisRas'])->name('fines-total-recaudado-mes-cuis-ras');
    Route::post('/fines-ingreso-mes-cuis-ras',[FinesController::class,'getIngresoMesCuisRas'])->name('fines-ingreso-mes-cuis-ras');
    Route::post('/fines-recorrido-dia-cuis-ras',[FinesController::class,'getRecorridoDiaCuisRas'])->name('fines-recorrido-dia-cuis-ras');
    Route::post('/fines-list-cuis-ras',[FinesController::class,'getListCuisRas'])->name('fines-list-cuis-ras');
    
    Route::get('/taxes',[TaxesController::class,'index'])->name('taxes');
    Route::get('/taxes-list',[TaxesController::class,'getTributo'])->name('taxes-list');
    Route::post('/taxes-total-recaudado-tributo',[TaxesController::class,'getTotalRecaudadoTributo'])->name('taxes-total-recaudado-tributo');
    Route::post('/taxes-total-recaudado-mes-tributo',[TaxesController::class,'getTotalRecaudadoMesTributo'])->name('taxes-total-recaudado-mes-tributo');
    Route::post('/taxes-ingreso-mes-tributo',[TaxesController::class,'getIngresoMesTributo'])->name('taxes-ingreso-mes-tributo');
    Route::post('/taxes-recorrido-dia-tributo',[TaxesController::class,'getRecorridoDiaTributo'])->name('taxes-recorrido-dia-tributo');
    Route::post('/taxes-list-tributo',[TaxesController::class,'getListTributo'])->name('taxes-list-tributo');
    
    Route::get('/departure',[DepartureController::class,'index'])->name('departure');
    Route::post('/departure-total-recaudado-fecha-rango',[DepartureController::class,'getTotalRecaudadoFechaRango'])->name('departure-total-recaudado-fecha-rango');
    Route::post('/departure-total-ingreso-partida',[DepartureController::class,'getTotalIngresoPartida'])->name('departure-total-ingreso-partida');
    Route::post('/departure-top-cinco-partida-recaudado',[DepartureController::class,'getTopCincoPartidasRecaudados'])->name('departure-top-cinco-partida-recaudado');
    Route::post('/departure-total-ingreso-partida-detallado',[DepartureController::class,'getTotalIngresoPartidaDetallado'])->name('departure-total-ingreso-partida-detallado');
});
