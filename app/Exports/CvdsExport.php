<?php

namespace App\Exports;

use App\CvDs;
use Maatwebsite\Excel\Concerns\FromCollection;

class CvdsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CvDs::all();
    }
}
