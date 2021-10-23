<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserExport implements FromArray, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        $table = 'users';
        $data = DB::table($table)->get()->toArray();
        return $data;
    }

    public function map($dataUser): array
    {
        return [
            $dataUser->uuid,
            $dataUser->password,
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Password',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:R1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
}
