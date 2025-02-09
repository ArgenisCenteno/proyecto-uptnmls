<?php
namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * Fetch all products with related subcategoria and categoria.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Producto::with([
            'subCategoria.categoria' // Load related subcategoria and categoria
        ])->get();
    }

    /**
     * Define the headers for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Descripción',
            'Unidad de Medida',
            'Cantidad',
            'Subcategoria',
            'Categoría',
            'Disponible',
            'Tipo'
        ];
    }

    /**
     * Map the data for each product.
     *
     * @param \App\Models\Producto $producto
     * @return array
     */
    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->nombre,
            $producto->descripcion,
            $producto->unidad_medida,
            $producto->cantidad,
            $producto->subCategoria->nombre ?? 'N/A', // Access the subcategoria name
            $producto->subCategoria->categoria->nombre ?? 'N/A', // Access the category name
            $producto->disponible ? 'Sí' : 'No',
            $producto->tipo
        ];
    }
}
