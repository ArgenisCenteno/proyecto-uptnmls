<?php
namespace App\Exports;

use App\Models\Personal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PersonalExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * Fetch all the personal data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Personal::all(); // Retrieve all records from the 'personals' table
    }

    /**
     * Define the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Teléfono',
            'RIF',
            'Dirección',
            'Estado',
            'Área'
        ];
    }

    /**
     * Map the data for each personal record.
     *
     * @param \App\Models\Personal $personal
     * @return array
     */
    public function map($personal): array
    {
        return [
            $personal->id,
            $personal->nombre,
            $personal->telefono,
            $personal->rif,
            $personal->direccion,
            $personal->estado,
            $personal->area,
        ];
    }
}
