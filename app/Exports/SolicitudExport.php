<?php
// app/Exports/SolicitudExport.php

namespace App\Exports;

use App\Models\Solicitud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SolicitudExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return Solicitud::with(['user', 'proveedor'])
            ->whereBetween('fecha', [$this->fromDate, $this->toDate])
            ->get()
            ->map(function ($solicitud) {
                return [
                    'ID' => $solicitud->id,
                    'Fecha' => $solicitud->fecha,
                    'Descripción' => $solicitud->descripcion,
                    'Financiamiento' => $solicitud->financiamiento,
                    'Proveedor' => $solicitud->proveedor->razon_social ?? 'N/A', // Accessing razon_social
                    'Creado por' => $solicitud->user->name ?? 'N/A', // Accessing name
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Descripción',
            'Financiamiento',
            'Proveedor',
            'Creado por',
        ];
    }
}
