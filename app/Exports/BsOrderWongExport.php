<?php

namespace App\Exports;

use App\BsOrderWong;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BsOrderWongExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Array
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
        return ["Order Number",
                "Full Name (Shipping)",
                "Address 1 (Shipping)",
                "Address 2 (Shipping)",
                "City (Shipping)",
                "PostCode (Shipping)",
                "State Code (Shipping)",
                "Country Code (Shipping)",
                "Phone (Billing)",
                "Product Variation",
                "Item SKU",
                "Quantity",
                "Base Cost",
                "Quantity*Base Cost"];
    }
}
