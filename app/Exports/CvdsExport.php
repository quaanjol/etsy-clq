<?php

namespace App\Exports;

use App\CvDs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CvdsExport implements FromArray, WithHeadings
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
        return ["Reference Id",
                "Quantity",
                "Item Variant ID",
                "First Name",
                "Last Name",
                "Street 1",
                "Street 2",
                "City",
                "State",
                "Country",
                "Zip",
                "Phone",
                "Force Verified Delivery",
                "Print Area 1",
                "Artwork URL 1",
                "Resize 1",
                "Position 1",
                "Print Area 2",
                "Artwork URL 2",
                "Resize 2",
                "Position 2",
                "Print Area 3",
                "Artwork URL 3",
                "Resize 3",
                "Position 3",
                "Print Area 4",
                "Artwork URL 4",
                "Resize 4",
                "Position 4",
                "Print Area 5",
                "Artwork URL 5",
                "Resize 5",
                "Position 5",
                "Test Order"];
    }
}
