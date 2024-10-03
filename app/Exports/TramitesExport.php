<?php

namespace App\Exports;

use App\Models\Tramites;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TramitesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    protected $fromDate;
    protected $toDate;

    // Recibir el rango de fechas para la exportación
    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    // Recoger los datos para exportar
    public function collection()
    {
        return Tramites::whereBetween('fecha', [$this->fromDate, $this->toDate])
            ->with(['user', 'personal'])  // Relacionamos los modelos
            ->get()
            ->map(function($tramite) {
                return [
                    'ID' => $tramite->id,
                    'Fecha' => $tramite->fecha,
                    'Tipo' => $tramite->tipo,
                    'Descripción' => $tramite->descripcion,
                    'Personal' => $tramite->personal->name ?? 'N/A',  // Nombre del personal
                    'Creado por' => $tramite->user->name ?? 'N/A',    // Nombre del usuario
                    'Estado' => $tramite->estado,
                ];
            });
    }

    // Cabeceras para el archivo Excel
    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Tipo',
            'Descripción',
            'Personal',
            'Creado por',
            'Estado',
        ];
    }
}
