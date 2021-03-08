<?php

namespace App\Exports;

use App\BsManagement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BsManagementExports implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection($bsManagements)
    // {
    //     // return BsManagement::all();
    //     return new Collection($bsManagements);
    // }

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
    // public function headings() :array {
    //     return ["Order Date/ PayPal Invoice Id", 
    //             "Tracking Number", 
    //             "Order Number", 
    //             "Order Date", 
    //             "Email(Billing)", 
    //             "Shipping Method Title", 
    //             "Quantity", 
    //             "Item Name", 
    //             "Full Name (Shipping)", 
    //             "Address 1 (Shipping)", 
    //             "Address 2 (Shipping)", 
    //             "City (Shipping)", 
    //             "State Code (Shipping)", 
    //             "Zip Code (Shipping)", 
    //             "Country Code (Shipping)", 
    //             "Phone (Billing)", "Transaction ID", 
    //             "Product Variation", 
    //             "Image URL", 
    //             "Item Sku", 
    //             "Quantity", 
    //             "Base Cost", 
    //             "Quantity*Base Cost"];
    // }
}
