<?php

namespace App\Exports;

use App\Models\Asignacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AsignacionExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $fromDate;
    protected $toDate;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function collection()
    {
        return Asignacion::with(['creador', 'personal'])
            ->whereBetween('fecha', [$this->fromDate, $this->toDate])
            ->get()
            ->map(function ($asignacion) {
                return [
                    'ID' => $asignacion->id,
                    'Fecha' => $asignacion->fecha,
                    'Descripción' => $asignacion->descripcion,
                   
                    'Creado por' => $asignacion->creador->name ?? 'N/A', // Accessing the creator's name
                    'Personal' => $asignacion->personal->nombre ?? 'N/A', // Accessing the personal's name
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Descripción',
            
            'Creado por',
            'Personal',
        ];
    }
}
