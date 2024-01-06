<?php

namespace App\Exports;

use App\Models\Letter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Letter::all();
    }

    public function headings(): array
    {
        return [
            "Nomor Surat", "Perihal", "Tanggal Keluar", "Penerima Surat", "Notulis"
        ];
    }


    public function map($letter): array
    {
        // Ambil array penerima surat
        $recipients = $letter->recipients ? json_decode($letter->recipients) : [];

        // Ambil nama penerima surat
        $recipientNames = [];
        foreach ($recipients as $recipientId) {
            $recipient = \App\Models\User::find($recipientId);
            if ($recipient) {
                $recipientNames[] = $recipient->name;
            }
        }

        return [
            $letter->letterType->letter_code,
            $letter->letter_perihal,
            $letter->created_at,
            implode(", ", $recipientNames), // Gabungkan nama penerima surat menjadi satu string dipisahkan koma
            $letter->notulisUser->name
        ];
    }
}
