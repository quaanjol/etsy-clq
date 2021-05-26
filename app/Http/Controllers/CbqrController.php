<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BsManagement;
use App\Models\BsOrderWong;
use App\Models\CvDs;
use App\Models\Cbqr;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BsManagementExports;
use App\Exports\BsOrderWongExport;
use App\Exports\CvdsExport;
use App\Exports\CbqrExport;

class CbqrController extends Controller
{
    // cbqr handle
    public function convert() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Tạo file CBQR", "english" => "Dashboard"];

        return view('admin.web.admin.cbqr.convert')->with([
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading,
        ]);
    }

    public function convertStore(Request $request) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        
        $file = $request->file;
        $csv = array_map('str_getcsv', file($file));

        $cbqrs = [];
        foreach($csv as $index => $row) {
            if($index == 0) {
                continue;
            }

            try {
                $prdDetails = [];

                if(strpos($row[31], "|")) {
                    $prdDetails = explode("|", $row[31]);
                } else {
                    $prdDetails[] = $row[31];
                }
                
                foreach($prdDetails as $prdDetail) {
                    $nameColumn = explode(", P", $prdDetail)[3];
                    $quantityColumn = explode(", P", $prdDetail)[1];
                    $variationColumn = explode(", P", $prdDetail)[4];
                    $prdName = explode(": ", $nameColumn)[1];
                    if(strpos($prdName, "Rug, Quilt, Bedding Set, Landscape Canvas") !== false) {
                        $cbqr = new Cbqr();
                        $cbqr->order_date = "'" . date("ymd");
                        $cbqr->order_number = strtoupper($row[0]) . "#" . $row[1];
                        $cbqr->customer_note = "";
                        $cbqr->email_billing = $row[9];
                        $cbqr->quantity = explode(": ", $quantityColumn)[1];
                        $cbqr->item_name = $prdName;
                        $cbqr->sku = "";
                        $cbqr->full_name = $row[8];
                        $cbqr->address1 = $row[21];
                        $cbqr->address2 = $row[22];
                        $cbqr->city = $row[23];
                        $cbqr->state_code = $row[24];
                        $cbqr->zip_code = $row[26];
                        $cbqr->country_code = $row[27];
                        if(strpos($row[29], "+") !== false) {
                            $cbqr->phone = "'" . str_replace("+", "", $row[29]);
                        } else {
                            $cbqr->phone = "'" . $row[29];
                        }
                        $cbqr->transaction_id = $row[32];
                        $cbqr->product_variation = explode(": ", $variationColumn)[2];
                        $cbqr->customer_note2 = "";
                        $cbqr->item_sku = '';
                        $cbqrs[] = $cbqr;
                    }
                }
            } catch (Exception $e) {
                
            }
            
        }

        // dd($bsManagements);
        $collection = new Collection();
        foreach($cbqrs as $cbqr){
            $collection->push((object)[
                'order_date' => $cbqr->order_date,
                'order_number' => $cbqr->order_number,
                'customer_note' => $cbqr->customer_note,
                'email_billing' => $cbqr->email_billing,
                'quantity' => $cbqr->quantity,
                'item_name' => $cbqr->item_name,
                'sku' => $cbqr->sku,
                'full_name' => $cbqr->full_name,
                'address1' => $cbqr->address1,
                'address2' => $cbqr->address2,
                'city' => $cbqr->city,
                'state_code' => $cbqr->state_code,
                'zip_code' => $cbqr->zip_code,
                'country_code' => $cbqr->country_code,
                'phone' => $cbqr->phone,
                'transaction_id' => $cbqr->transaction_id,
                'product_variation' => $cbqr->product_variation,
                'customer_note2' => $cbqr->customer_note2,
                'item_sku' => $cbqr->item_sku,
            ]);

        }
        
        $excelArray = [];
        foreach($collection as $cbqr) {
            $tmp = [];
            foreach($cbqr as $key => $value) {
                $tmp[$key] = $value;
            }
            array_push($excelArray, $tmp);
        }
        // dd($excelArray);
        return Excel::download(new CbqrExport($excelArray), 'cbqr.csv');
    }
}
