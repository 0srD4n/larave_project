<?php

namespace App\Exports;

use App\Models\Keterlambatan;
use Maatwebsite\Excel\Concerns\FromCollection;

class KeterlambatanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Keterlambatan::all();
    }
}
