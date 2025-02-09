<?php
namespace App\Exports;

use App\Models\ProductoPendiente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosPendientesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    // Constructor to accept date range
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return ProductoPendiente::with([
            'productoAsignado.asignacion.personal', 
            'tramite.user'
        ])
        ->whereBetween('fecha_entrega', [$this->startDate, $this->endDate]) // Filter by date range
        ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Producto',
            'Cantidad',
            'Fecha de Entrega',
            'Observaciones',
            'Personal Asignado',
            'Trámite Creado Por'
        ];
    }

    public function map($productoPendiente): array
    {
        return [
            $productoPendiente->id,
            $productoPendiente->productoAsignado->producto->nombre ?? 'N/A',
            $productoPendiente->cantidad,
            $productoPendiente->fecha_entrega ?? 'N/A',
            $productoPendiente->observaciones ?? 'N/A',
            $productoPendiente->productoAsignado->asignacion->personal->nombre ?? 'N/A',
            $productoPendiente->tramite->user->name ?? 'N/A',
        ];
    }
}
