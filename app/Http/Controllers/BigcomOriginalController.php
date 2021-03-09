<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BsManagement;
use App\Models\BsOrderWong;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BsManagementExports;
use App\Exports\BsOrderWongExport;

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
        // dd(bcrypt('admin123'));

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
            } else if(strpos(explode(": ", $row[3])[1], 'Bedding Set') !== false) {
                $bsManagement = new BsManagement();
                $info = explode(";", $row[0]);
                $bsManagement->order_date = "'" . date('ymd', strtotime($info[3]));
                $bsManagement->tracking_number = '';
                $bsManagement->order_number = strtoupper($info[0]) . "#" . $info[1];
                $bsManagement->order_date2 = $info[3];
                $bsManagement->customer_note = "";
                $bsManagement->email_billing = $info[9];
                $bsManagement->order_status = "";
                $bsManagement->paid_date = "";
                $bsManagement->shipping_method = $info[11];
                $bsManagement->shipping_method2 = "";
                $bsManagement->quantity = explode(": ", $row[1])[1];
                $bsManagement->item_name = explode(": ", $row[3])[1];
                $bsManagement->sku = "";
                $bsManagement->full_name = $info[8];
                $bsManagement->address1 = $info[21];
                $bsManagement->address2 = $info[22];
                $bsManagement->city = $info[23];
                $bsManagement->state_code = $info[24];
                $bsManagement->zip_code = $info[26];
                $bsManagement->country_code = $info[27];
                if(strpos($info[29], " ") !== false) {
                    $bsManagement->phone = "'" . explode(" ", $info[29])[1];
                } else {
                    $bsManagement->phone = "'" . $info[29];
                }
                $bsManagement->transaction_id = explode(";", explode(": ", $row[6])[1])[1];
                $bsManagement->product_variation = explode(': ', $row[4])[2];
                $bsManagement->image_url = '';
                $bsManagement->order_refund_amount = '';
                $bsManagement->customer_note2 = "";
                $bsManagement->item_sku = '';
                $bsManagement->quantity2 = explode(": ", $row[1])[1];
                if(trim($bsManagement->product_variation, " ") == 'AU Double') {
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
                
                $bsManagement->total_price = $bsManagement->base_cost*$bsManagement->quantity2;
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
        // return redirect('/admin/bigcomoriginal/convert/bs/order');

        // return view('admin.web.bigcomoriginal.managementPreview')->with([
        //     'theme' => $theme,
        //     'user' => $user,
        //     'heading' => $heading,
        //     'bsManagements' => $collection
        // ]);
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

        foreach($csv as $index => $row) {
            $bsOrderWong = new BsOrderWong();
            $bsOrderWong->order_number = $row[2];
            $bsOrderWong->full_name = $row[13];
            $bsOrderWong->address1 = $row[14];
            $bsOrderWong->address2 = $row[15];
            $bsOrderWong->city = $row[16];
            $bsOrderWong->post_code = $row[18];
            $bsOrderWong->state_code = $row[17];
            $bsOrderWong->country_code = $row[19];
            $bsOrderWong->phone = $row[20];
            $bsOrderWong->product_variation = $row[22];
            $bsOrderWong->item_sku = $row[26];
            $bsOrderWong->quantity = $row[27];
            $bsOrderWong->base_cost = $row[28];
            $bsOrderWong->total_price = $row[29];
            $bsOrders[] = $bsOrderWong;
        }

        // dd($bsManagements);
        $collection = new Collection();
        foreach($bsOrders as $bsOrder){
            $collection->push((object)['order_number' => $bsOrder->order_number,
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
            // $excelArray[] = $tmp;
            array_push($excelArray, $tmp);
        }
        // dd($excelArray);
        return Excel::download(new BsOrderWongExport($excelArray), 'Wong-bedding_Kimberly.xlsx');
        // return redirect('/admin/bigcomoriginal/convert/bs/management');
    }
}
