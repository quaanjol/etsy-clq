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
use App\Exports\CvdsExport;

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
        $bsManagements = [];
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
                    $nameColumn = explode(", ", $prdDetail)[3];
                    $quantityColumn = explode(", ", $prdDetail)[1];
                    $variationColumn = explode(", ", $prdDetail)[4];
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
        // return view('admin.web.bigcomoriginal.fileOrderPreview')->with([
        //     'excelArray' => $excelArray,
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
        // dd($csv);
        $cvdses = [];
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
                    $nameColumn = explode(", ", $prdDetail)[3];
                    $quantityColumn = explode(", ", $prdDetail)[1];
                    $variationColumn = explode(", ", $prdDetail)[4];
                    $prdName = explode(": ", $nameColumn)[1];
                    if(strpos($prdName, "Bedding Set") == false) {
                        // dd($prdName);
                        $cvds = new CvDs();
                        $cvds->reference_id = strtoupper($row[0]) . "#" . $row[1];
                        $cvds->quantity = explode(": ", $quantityColumn)[1];
    
                        // default resize 1 and position 1
                        $cvds->resize1 = "fill";
                        $cvds->position1 = "center_center";
                        
                        $size = explode(": ", $variationColumn)[2];
                        // in case of canvas poster
                        if(strpos($prdName, "Wall Art Poster") !== false) {
                            if(strpos($size, "in") !== false) {
                                $size = str_replace("in", "", $size);
                                $cvds->print_area_key1 = $size;
                                if($size == "10x8") {
                                    $cvds->item_variant_id = "1227";
                                } elseif ($size == "8x10") {
                                    $cvds->item_variant_id = "1226";
                                } elseif ($size == "24x16") {
                                    $cvds->item_variant_id = "4333";
                                } elseif ($size == "16x24") {
                                    $cvds->item_variant_id = "4329";
                                } elseif ($size == "40x27") {
                                    $cvds->item_variant_id = "4339";
                                } elseif ($size == "27x40") {
                                    $cvds->item_variant_id = "4336";
                                }
                            }
                        }
    
                        // in case of canvas blanket
                        if(strpos($prdName, "Blanket") !== false) {
                            $cvds->print_area_key1 = $size;
                            if($size == "30x40") {
                                $cvds->item_variant_id = "746";
                            } elseif ($size == "50x60") {
                                $cvds->item_variant_id = "747";
                            } elseif ($size == "60x80") {
                                $cvds->item_variant_id = "748";
                            }
                        }
    
                        // in case of canvas wall art 1P, 3P, 5P
                        if(strpos($prdName, "Canvas Wall Decor") !== false || strpos($prdName, "Canvas Art Print") !== false) {
                            if(strpos($size, " ") !== false) {
                                $panel = explode(" ", $size)[0];
                                $size = explode(" ", $size)[1];
        
                                if ($panel == "1P") {
                                    $cvds->print_area_key1 = $size;
                                    if($size == "10x8") {
                                        $cvds->item_variant_id = "750";
                                    } elseif ($size == "24x16") {
                                        $cvds->item_variant_id = "758";
                                    } elseif ($size == "36x24") {
                                        $cvds->item_variant_id = "760";
                                    } elseif ($size == "48x32") {
                                        $cvds->item_variant_id = "762";
                                    }
                                } elseif ($panel == "3P") {
                                    $cvds->resize2 = "fill";
                                    $cvds->position2 = "center_center";
                                    $cvds->resize3 = "fill";
                                    $cvds->position3 = "center_center";
    
                                    if ($size == "38x18") {
                                        $cvds->print_area_key1 = "1_12x18";
                                        $cvds->print_area_key2 = "2_12x18";
                                        $cvds->print_area_key3 = "3_12x18";
                                        $cvds->item_variant_id = "3375";
                                    } elseif ($size == "50x24") {
                                        $cvds->print_area_key1 = "1_16x24";
                                        $cvds->print_area_key2 = "2_16x24";
                                        $cvds->print_area_key3 = "3_16x24";
                                        $cvds->item_variant_id = "3376";
                                    }
                                } elseif ($panel == "5P") {
                                    $cvds->resize2 = "fill";
                                    $cvds->position2 = "center_center";
                                    $cvds->resize3 = "fill";
                                    $cvds->position3 = "center_center";
                                    $cvds->resize4 = "fill";
                                    $cvds->position4 = "center_center";
                                    $cvds->resize5 = "fill";
                                    $cvds->position5 = "center_center";
    
                                    if ($size == "64x32") {
                                        $cvds->print_area_key1 = "1_12x16";
                                        $cvds->print_area_key2 = "2_12x16";
                                        $cvds->print_area_key3 = "3_12x24";
                                        $cvds->print_area_key4 = "4_12x24";
                                        $cvds->print_area_key5 = "5_12x32";
                                        $cvds->item_variant_id = "3378";
                                    } elseif ($size == "64x36") {
                                        $cvds->print_area_key1 = "1_12x36";
                                        $cvds->print_area_key2 = "2_12x36";
                                        $cvds->print_area_key3 = "3_12x36";
                                        $cvds->print_area_key4 = "4_12x36";
                                        $cvds->print_area_key5 = "5_12x36";
                                        $cvds->item_variant_id = "3379";
                                    } elseif ($size == "84x40") {
                                        $cvds->print_area_key1 = "1_16x24";
                                        $cvds->print_area_key2 = "2_16x24";
                                        $cvds->print_area_key3 = "3_16x32";
                                        $cvds->print_area_key4 = "4_16x32";
                                        $cvds->print_area_key5 = "5_16x40";
                                        $cvds->item_variant_id = "3377";
                                    } elseif ($size == "84x48") {
                                        $cvds->print_area_key1 = "1_16x48";
                                        $cvds->print_area_key2 = "2_16x48";
                                        $cvds->print_area_key3 = "3_16x48";
                                        $cvds->print_area_key4 = "4_16x48";
                                        $cvds->print_area_key5 = "5_16x48";
                                        $cvds->item_variant_id = "3380";
                                    }
                                }
        
                            }
                        }
    
                        $cvds->first_name = $row[18];
                        $cvds->last_name = $row[19];
                        $cvds->street1 = $row[21];
                        $cvds->street2 = $row[22];
                        $cvds->city = $row[23];
                        $cvds->state = $row[24];
                        $cvds->country = $row[27];
                        $cvds->zip = $row[26];
                        if(strpos($row[29], "+") !== false) {
                            $cvds->phone = "'" . str_replace("+", "", $row[29]);
                        } else {
                            $cvds->phone = "'" . $row[29];
                        }
                        $cvdses[] = $cvds;
                    }
                }

            } catch (Exception $e) {

            }

        }

        // dd($bsManagements);
        $collection = new Collection();
        foreach($cvdses as $cvds){
            $collection->push((object)[
                'reference_id' => $cvds->reference_id,
                'quantity' => $cvds->quantity,
                'item_variant_id' => $cvds->item_variant_id,
                'first_name' => $cvds->first_name,
                'last_name' => $cvds->last_name,
                'street1' => $cvds->street1,
                'street2' => $cvds->street2,
                'city' => $cvds->city,
                'state' => $cvds->state,
                'country' => $cvds->country,
                'zip' => $cvds->zip,
                'phone' => $cvds->phone,
                'force_verified_delivery' => $cvds->force_verified_delivery,
                'print_area_key1' => $cvds->print_area_key1,
                'artwork_url1' => $cvds->artwork_url1,
                'resize1' => $cvds->resize1,
                'position1' => $cvds->position1,
                'print_area_key2' => $cvds->print_area_key2,
                'artwork_url2' => $cvds->artwork_url2,
                'resize2' => $cvds->resize2,
                'position2' => $cvds->position2,
                'print_area_key3' => $cvds->print_area_key3,
                'artwork_url3' => $cvds->artwork_url3,
                'resize3' => $cvds->resize3,
                'position3' => $cvds->position3,
                'print_area_key4' => $cvds->print_area_key4,
                'artwork_url4' => $cvds->artwork_url4,
                'resize4' => $cvds->resize4,
                'position4' => $cvds->position4,
                'print_area_key5' => $cvds->print_area_key5,
                'artwork_url5' => $cvds->artwork_url5,
                'resize5' => $cvds->resize5,
                'position5' => $cvds->position5,
                'test_order' => $cvds->test_order,
            ]);

        }
        
        // dd($bsManagements[0]);
        $excelArray = [];
        foreach($collection as $csdv) {
            $tmp = [];
            foreach($csdv as $key => $value) {
                $tmp[$key] = $value;
            }
            // $excelArray[] = $tmp;
            array_push($excelArray, $tmp);
        }
        // dd($excelArray);
        return Excel::download(new CvdsExport($excelArray), 'canvas-management.csv');
    }
}
