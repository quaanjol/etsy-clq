<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BigcomAddTrackingExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $excelArray;

    public function __construct(array $excelArray)
    {
        $this->excelArray = $excelArray;
    }

    public function array(): array
    {
        return $this->excelArray;
    }

    //Thêm hàng tiêu đề cho bảng
    public function headings() :array {
        return ["order_number", 
            "tracking_number", 
            "tracking_carrier"];
    }
}
