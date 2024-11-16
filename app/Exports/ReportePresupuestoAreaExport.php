<?php

namespace App\Exports;

use App\Models\Mes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
class ReportePresupuestoAreaExport implements FromCollection,WithHeadings,WithEvents
{
    use Exportable;

    private $date_start;
    private $date_finish;
    
    public function __construct($date_start,$date_finish)
    {
        $this->date_start = $date_start;
        $this->date_finish = $date_finish;
        
        return $this;
    }

    public function collection()
    {
        $exec = DB::select("SET NOCOUNT ON; EXEC dbo.Sp_PresupuestoxArea ?, ?", [ "$this->date_start","$this->date_finish"]);
        return collect($exec);
    }

    public function headings(): array
    {
        // Definir los nombres de las columnas
        return [
            'NUM. DE PARTIDA',
            'PARTIDA DESC',
            'DESCRIPCION',
            'CONCEPTO',
            'UNIDAD',
            'FECHA_PARTIDA',
            'RUBRO',
            'MONTO',
            // Agregar más nombres de columnas según sea necesario
        ];
    }
    public function registerEvents(): array{
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $columnIndexA = Coordinate::columnIndexFromString('A'); 
                $event->sheet->getColumnDimensionByColumn($columnIndexA)->setWidth(20); 

                $columnIndexB = Coordinate::columnIndexFromString('B');
                $event->sheet->getColumnDimensionByColumn($columnIndexB)->setWidth(50);

                $columnIndexC = Coordinate::columnIndexFromString('C');
                $event->sheet->getColumnDimensionByColumn($columnIndexC)->setWidth(50);

                $columnIndexD = Coordinate::columnIndexFromString('D');
                $event->sheet->getColumnDimensionByColumn($columnIndexD)->setWidth(20);

                $columnIndexE = Coordinate::columnIndexFromString('E');
                $event->sheet->getColumnDimensionByColumn($columnIndexE)->setWidth(50);

                $columnIndexF = Coordinate::columnIndexFromString('F');
                $event->sheet->getColumnDimensionByColumn($columnIndexF)->setWidth(20);

                $columnIndexG = Coordinate::columnIndexFromString('G');
                $event->sheet->getColumnDimensionByColumn($columnIndexG)->setWidth(10);

                $columnIndexH = Coordinate::columnIndexFromString('H');
                $event->sheet->getColumnDimensionByColumn($columnIndexH)->setWidth(10);

                 $sheet = $event->sheet->getDelegate();

                 $titleRow = 1;
 
                 $titleRange = 'A'.$titleRow.':'.$sheet->getHighestColumn().$titleRow;

                 $sheet->getStyle($titleRange)->applyFromArray([
                     'fill' => [
                         'fillType' => Fill::FILL_SOLID,
                         'startColor' => [
                             'argb' => '44AACD', 
                         ],
                     ],
                 ]);

                 $sheet->getStyle($titleRange)->applyFromArray([
                     'font' => [
                        'bold' => true,
                        'size' => 14,
                        'color' => [
                             'rgb' => 'ffffff', 
                        ],
                     ],
                 ]);

            },
        ];
    }
}