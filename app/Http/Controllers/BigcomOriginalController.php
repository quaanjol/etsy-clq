<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BsManagement;
use App\Models\BsOrderWong;
use App\Models\CvDs;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BsManagementExports;
use App\Exports\BsOrderWongExport;
use App\Exports\CvDsExport;

class BigcomOriginalController extends Controller
{
    // show
    public function show() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Tạo file management", "english" => "Dashboard"];

        return view('admin.web.bigcomoriginal.convertBsm')->with([
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading,
        ]);
    }

    // convert to management file
    public function convertManagement(Request $request) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Tạo file order", "english" => "Dashboard"];
        $file = $request->file;
        $csv = array_map('str_getcsv', file($file));
        // dd($csv);
        $bsManagements = [];
        foreach($csv as $index => $row) {
            if($index == 0) {
                continue;
            }

            try {
                $nameColumn = explode(", ", $row[31])[3];
                $quantityColumn = explode(", ", $row[31])[1];
                $variationColumn = explode(", ", $row[31])[4];
                $prdName = explode(": ", $nameColumn)[1];
                if(strpos($prdName, "Bedding Set") !== false) {
                    // dd($prdName);
                $bsManagement = new BsManagement();
                $bsManagement->order_date = "'" . date("ymd");
                $bsManagement->tracking_number = '';
                $bsManagement->order_number = strtoupper($row[0]) . "#" . $row[1];
                $bsManagement->order_date2 = $row[3];
                $bsManagement->customer_note = "";
                $bsManagement->email_billing = $row[9];
                $bsManagement->order_status = "";
                $bsManagement->paid_date = "";
                $bsManagement->shipping_method = $row[11];
                $bsManagement->shipping_method2 = "";
                $bsManagement->quantity = explode(": ", $quantityColumn)[1];
                $bsManagement->item_name = $prdName;
                $bsManagement->sku = "";
                $bsManagement->full_name = $row[8];
                $bsManagement->address1 = $row[21];
                $bsManagement->address2 = $row[22];
                $bsManagement->city = $row[23];
                $bsManagement->state_code = $row[24];
                $bsManagement->zip_code = $row[26];
                $bsManagement->country_code = $row[27];
                if(strpos($row[29], "+") !== false) {
                    $bsManagement->phone = "'" . str_replace("+", "", $row[29]);
                } else {
                    $bsManagement->phone = "'" . $row[29];
                }
                $bsManagement->transaction_id = $row[32];
                $bsManagement->product_variation = explode(": ", $variationColumn)[2];
                $bsManagement->image_url = '';
                $bsManagement->order_refund_amount = '';
                $bsManagement->customer_note2 = "";
                $bsManagement->item_sku = '';
                $bsManagement->quantity2 = explode(": ", $quantityColumn)[1];
                if($bsManagement->product_variation == 'AU Double') {
                    $bsManagement->base_cost = 28;
                } else if(trim($bsManagement->product_variation, " ") == 'EU Super King') {
                    $bsManagement->base_cost = 35;
                } else if(trim($bsManagement->product_variation, " ") == 'EU King') {
                    $bsManagement->base_cost = 28;
                } else if(trim($bsManagement->product_variation, " ") == 'EU Double') {
                    $bsManagement->base_cost = 27;
                } else if(trim($bsManagement->product_variation, " ") == 'EU Single') {
                    $bsManagement->base_cost = 24;
                } else if(trim($bsManagement->product_variation, " ") == 'AU Queen') {
                    $bsManagement->base_cost = 30;
                } else if(trim($bsManagement->product_variation, " ") == 'AU Single') {
                    $bsManagement->base_cost = 26;
                } else if(trim($bsManagement->product_variation, " ") == 'AU King') {
                    $bsManagement->base_cost = 32;
                } else if(trim($bsManagement->product_variation, " ") == 'US King') {
                    $bsManagement->base_cost = 35;
                } else if(trim($bsManagement->product_variation, " ") == 'US Twin') {
                    $bsManagement->base_cost = 26;
                } else if(trim($bsManagement->product_variation, " ") == 'US Full') {
                    $bsManagement->base_cost = 30;
                } else if(trim($bsManagement->product_variation, " ") == 'Us Queen') {
                    $bsManagement->base_cost = 31;
                }
                
                $bsManagement->total_price = (float)$bsManagement->base_cost*(float)$bsManagement->quantity2;
                $bsManagements[] = $bsManagement;
                }
            } catch (Exception $e) {
                
            }
            
        }

        // dd($bsManagements);
        $collection = new Collection();
        foreach($bsManagements as $bsManagement){
            $collection->push((object)[
                'order_date' => $bsManagement->order_date,
                'tracking_number' => $bsManagement->tracking_number,
                'order_number' => $bsManagement->order_number,
                'order_date2' => $bsManagement->order_date2,
                'customer_note' => $bsManagement->customer_note,
                'email_billing' => $bsManagement->email_billing,
                'order_status' => $bsManagement->order_status,
                'paid_date' => $bsManagement->paid_date,
                'shipping_method' => $bsManagement->shipping_method,
                'shipping_method2' => $bsManagement->shipping_method2,
                'quantity' => $bsManagement->quantity,
                'item_name' => $bsManagement->item_name,
                'sku' => $bsManagement->sku,
                'full_name' => $bsManagement->full_name,
                'address1' => $bsManagement->address1,
                'address2' => $bsManagement->address2,
                'city' => $bsManagement->city,
                'state_code' => $bsManagement->state_code,
                'zip_code' => $bsManagement->zip_code,
                'country_code' => $bsManagement->country_code,
                'phone' => $bsManagement->phone,
                'transaction_id' => $bsManagement->transaction_id,
                'product_variation' => $bsManagement->product_variation,
                'image_url' => $bsManagement->image_url,
                'order_refund_amount' => $bsManagement->order_refund_amount,
                'customer_note2' => $bsManagement->customer_note2,
                'item_sku' => $bsManagement->item_sku,
                'quantity2' => $bsManagement->quantity2,
                'base_cost' => $bsManagement->base_cost,
                'total_price' => $bsManagement->total_price
            ]);

        }
        
        $excelArray = [];
        foreach($collection as $bsManagement) {
            $tmp = [];
            foreach($bsManagement as $key => $value) {
                $tmp[$key] = $value;
            }
            array_push($excelArray, $tmp);
        }
        // dd($excelArray);
        return Excel::download(new BsManagementExports($excelArray), 'bs-management.csv');
    }

    // file order handle
    public function convertBso() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Tạo file order", "english" => "Dashboard"];
        

        return view('admin.web.bigcomoriginal.convertBso')->with([
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading,
        ]);
    }

    public function convertBsoStore(Request $request) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Tạo file order", "english" => "Dashboard"];
        $file = $request->file;
        $csv = array_map('str_getcsv', file($file));
        $bsOrders = [];

        // dd($csv);
        foreach($csv as $index => $row) {
            if($index == 0) {
                continue;
            } else {
                $roww = $row;
                $bsOrderWong = new BsOrderWong();
                $bsOrderWong->order_number = $roww[2];
                $bsOrderWong->full_name = $roww[13];
                $bsOrderWong->address1 = $roww[14];
                $bsOrderWong->address2 = $roww[15];
                $bsOrderWong->city = $roww[16];
                $bsOrderWong->post_code = $roww[18];
                $bsOrderWong->state_code = $roww[17];
                $bsOrderWong->country_code = $roww[19];
                $bsOrderWong->phone = $roww[20];
                $bsOrderWong->product_variation = $roww[22];
                $bsOrderWong->item_sku = $roww[26];
                $bsOrderWong->quantity = $roww[27];
                $bsOrderWong->base_cost = $roww[28];
                if(strpos($row[29], ";") !== false) {
                    $bsOrderWong->total_price = explode(";", $roww[29])[0];
                } else {
                    $bsOrderWong->total_price = $row[29];
                }
                $bsOrders[] = $bsOrderWong;
                // dd($bsOrderWong);
            } 
        }

        $collection = new Collection();
        foreach($bsOrders as $bsOrder){
            $collection->push((object)[
                'order_number' => $bsOrder->order_number,
                'full_name' => $bsOrder->full_name,
                'address1' => $bsOrder->address1,
                'address2' => $bsOrder->address2,
                'city' => $bsOrder->city,
                'post_code' => $bsOrder->post_code,
                'state_code' => $bsOrder->state_code,
                'country_code' => $bsOrder->country_code,
                'phone' => $bsOrder->phone,
                'product_variation' => $bsOrder->product_variation,
                'item_sku' => $bsOrder->item_sku,
                'quantity' => $bsOrder->quantity,
                'base_cost' => $bsOrder->base_cost,
                'total_price' => $bsOrder->total_price
            ]);
        }
        
        // dd($bsManagements[0]);
        $excelArray = [];
        foreach($collection as $bsOrder) {
            $tmp = [];
            foreach($bsOrder as $key => $value) {
                $tmp[$key] = $value;
            }
            array_push($excelArray, $tmp);
        }
        // dd($excelArray);
        return Excel::download(new BsOrderWongExport($excelArray), 'Wong-bedding_Kimberly.xlsx');
    }

    // convert canvas file 
    public function convertCanvasDs() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Tạo file Canvas Order Dreamship", "english" => "Dashboard"];

        return view('admin.web.bigcomoriginal.convertCvDs')->with([
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading,
        ]);
    }

    public function convertCanvasDsStore(Request $request) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }

        $file = $request->file;
        $csv = array_map('str_getcsv', file($file));
        dd($csv);
        $bsManagements = [];
        foreach($csv as $index => $row) {
            if($index == 0) {
                continue;
            }

            $prdName = explode(": ", $row[35])[1];
            if(strpos($prdName, "Bedding Set") == false) {
                // dd($prdName);
                $bsManagement = new BsManagement();
                $bsManagement->order_date = "'" . date("ymd");
                $bsManagement->tracking_number = '';
                $bsManagement->order_number = strtoupper($row[0]) . "#" . $row[1];
                $bsManagement->order_date2 = $row[3];
                $bsManagement->customer_note = "";
                $bsManagement->email_billing = $row[10];
                $bsManagement->order_status = "";
                $bsManagement->paid_date = "";
                $bsManagement->shipping_method = $row[12];
                $bsManagement->shipping_method2 = "";
                $bsManagement->quantity = explode(": ", $row[33])[1];
                $bsManagement->item_name = $prdName;
                $bsManagement->sku = "";
                $bsManagement->full_name = $row[9];
                $bsManagement->address1 = $row[22];
                $bsManagement->address2 = $row[23];
                $bsManagement->city = $row[24];
                $bsManagement->state_code = $row[25];
                $bsManagement->zip_code = $row[27];
                $bsManagement->country_code = $row[28];
                if(strpos($row[30], "+") !== false) {
                    $bsManagement->phone = "'" . str_replace("+", "", $row[30]);
                } else {
                    $bsManagement->phone = "'" . $row[30];
                }
                $bsManagement->transaction_id = $row[39];
                $bsManagement->product_variation = explode(": ", $row[36])[2];
                $bsManagement->image_url = '';
                $bsManagement->order_refund_amount = '';
                $bsManagement->customer_note2 = "";
                $bsManagement->item_sku = '';
                $bsManagement->quantity2 = explode(": ", $row[33])[1];
                if($bsManagement->product_variation == 'AU Double') {
                    $bsManagement->base_cost = 28;
                } else if(trim($bsManagement->product_variation, " ") == 'EU Super King') {
                    $bsManagement->base_cost = 35;
                } else if(trim($bsManagement->product_variation, " ") == 'EU King') {
                    $bsManagement->base_cost = 28;
                } else if(trim($bsManagement->product_variation, " ") == 'EU Double') {
                    $bsManagement->base_cost = 27;
                } else if(trim($bsManagement->product_variation, " ") == 'EU Single') {
                    $bsManagement->base_cost = 24;
                } else if(trim($bsManagement->product_variation, " ") == 'AU Queen') {
                    $bsManagement->base_cost = 30;
                } else if(trim($bsManagement->product_variation, " ") == 'AU Single') {
                    $bsManagement->base_cost = 26;
                } else if(trim($bsManagement->product_variation, " ") == 'AU King') {
                    $bsManagement->base_cost = 32;
                } else if(trim($bsManagement->product_variation, " ") == 'US King') {
                    $bsManagement->base_cost = 35;
                } else if(trim($bsManagement->product_variation, " ") == 'US Twin') {
                    $bsManagement->base_cost = 26;
                } else if(trim($bsManagement->product_variation, " ") == 'US Full') {
                    $bsManagement->base_cost = 30;
                } else if(trim($bsManagement->product_variation, " ") == 'Us Queen') {
                    $bsManagement->base_cost = 31;
                }
                
                $bsManagement->total_price = (float)$bsManagement->base_cost*(float)$bsManagement->quantity2;
                $bsManagements[] = $bsManagement;
            }
        }

        // dd($bsManagements);
        $collection = new Collection();
        foreach($bsManagements as $bsManagement){
            $collection->push((object)['order_date' => $bsManagement->order_date,
                                        'tracking_number' => $bsManagement->tracking_number,
                                        'order_number' => $bsManagement->order_number,
                                        'order_date2' => $bsManagement->order_date2,
                                        'customer_note' => $bsManagement->customer_note,
                                        'email_billing' => $bsManagement->email_billing,
                                        'order_status' => $bsManagement->order_status,
                                        'paid_date' => $bsManagement->paid_date,
                                        'shipping_method' => $bsManagement->shipping_method,
                                        'shipping_method2' => $bsManagement->shipping_method2,
                                        'quantity' => $bsManagement->quantity,
                                        'item_name' => $bsManagement->item_name,
                                        'sku' => $bsManagement->sku,
                                        'full_name' => $bsManagement->full_name,
                                        'address1' => $bsManagement->address1,
                                        'address2' => $bsManagement->address2,
                                        'city' => $bsManagement->city,
                                        'state_code' => $bsManagement->state_code,
                                        'zip_code' => $bsManagement->zip_code,
                                        'country_code' => $bsManagement->country_code,
                                        'phone' => $bsManagement->phone,
                                        'transaction_id' => $bsManagement->transaction_id,
                                        'product_variation' => $bsManagement->product_variation,
                                        'image_url' => $bsManagement->image_url,
                                        'order_refund_amount' => $bsManagement->order_refund_amount,
                                        'customer_note2' => $bsManagement->customer_note2,
                                        'item_sku' => $bsManagement->item_sku,
                                        'quantity2' => $bsManagement->quantity2,
                                        'base_cost' => $bsManagement->base_cost,
                                        'total_price' => $bsManagement->total_price
            ]);

        }
        
        // dd($bsManagements[0]);
        $excelArray = [];
        foreach($collection as $bsManagement) {
            $tmp = [];
            foreach($bsManagement as $key => $value) {
                $tmp[$key] = $value;
            }
            // $excelArray[] = $tmp;
            array_push($excelArray, $tmp);
        }
        // dd($excelArray);
        return Excel::download(new BsManagementExports($excelArray), 'bs-management.csv');
    }
}
