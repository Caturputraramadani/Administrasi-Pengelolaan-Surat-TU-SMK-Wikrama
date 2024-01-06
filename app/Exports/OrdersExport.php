<?php

namespace App\Exports;

use App\Models\LetterType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return LetterType::all();
    }

    public function headings(): array
    {
        return [
            "Kode Surat", "Klasifikasi Surat", "Surat Tertaut"
        ];
    }

    public function map($letterType): array
    {
        return [
            $letterType->letter_code,
            $letterType->name_type,
            $letterType->letter_count,
        ];
    }
}
