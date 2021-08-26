<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Carrier;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TrackingExport;
use App\Exports\BigcomAddTrackingExport;

class TrackingController extends Controller
{

    public function show() {

    }

    // trackingDs
    public function trackingDs() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Lấy tracking Dreamship", "english" => "Dashboard"];

        return view('admin.web.tracking.track')->with([
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading,
        ]);
    }

    public function trackingDsGet(Request $request) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }

        $theme = $user->theme;
        $heading = ["vietnamese" => "Kết quả", "english" => "Dashboard"];

        // apikey from dreamship
        $apiKey = '75c78111ba490927c174aa9107faf45d87e8e6dd';

        $bodyContent = [];
        $order_number = $request->order_number;
        $afterDate = $request->after_date;
        $beforeDate = $request->before_date;

        if($order_number != null) {
            $bodyContent['reference_id'] = $order_number;
        }
        
        if($afterDate != null && $beforeDate == null) {
            $bodyContent['created_at_after'] = $afterDate;
        } elseif ($afterDate == null && $beforeDate != null) {
            $bodyContent['created_at_before'] = $beforeDate;
        } elseif ($afterDate != null && $beforeDate != null) {
            $bodyContent['created_at_after'] = $afterDate;
            $bodyContent['created_at_before'] = $beforeDate;
        }
        // dd($bodyContent);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json'
            ])->get('https://api.dreamship.com/v1/orders', $bodyContent);
    
            $data = json_decode(str_replace("'", "", $response->body()));
    
            // Sort and print the resulting array
            uasort($data->data, array( $this, 'cmp' ));
            
            // dd($data->data);
            return view('admin.web.tracking.result')->with([
                'result' => $data->data,
                'theme' => $theme,
                'user' => $user,
                'heading' => $heading
            ]);
        } catch(\Exception $e) {
            $request->session()->flash('warning', $e->getMessage());
            return view('admin.web.tracking.result')->with([
                'result' => [],
                'theme' => $theme,
                'user' => $user,
                'heading' => $heading
            ]);
        }
    }

    // Comparison function
    public function cmp($a, $b) {
        if ($a->reference_id == $b->reference_id) {
            return 0;
        }
        return ($a->reference_id < $b->reference_id) ? -1 : 1;
    }

    public function trackingDsAfterDate(Request $request) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Lấy tracking Dreamship", "english" => "Dashboard"];

        return view('admin.web.tracking.afterdate')->with([
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading,
        ]);
    }

    public function trackingDsBeforeDate() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Lấy tracking Dreamship", "english" => "Dashboard"];

        return view('admin.web.tracking.beforedate')->with([
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading,
        ]);
    }

    public function trackingDsBetweenDate() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Lấy tracking Dreamship", "english" => "Dashboard"];

        return view('admin.web.tracking.betweendate')->with([
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading,
        ]);
    }

    public function trackingDsExport(Request $request) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }

        $download_type = $request->download_type;
        $order_type = $request->order_type;
        
        $excelArray = [];
        $totalOrder = $request->total_order;


        if($order_type == "") {
            for($i = 0; $i < $totalOrder; $i++) {
                $tmp = [];
    
                $thisIndex = $i;
                $orderNumberInput = $thisIndex . '_order_number';
                $createdAtInput = $thisIndex . '_created_at';
                $totalCostInput = $thisIndex . '_total_cost';
                $carrierInput = $thisIndex . '_carrier';
                $trackingInput = $thisIndex . '_tracking';
                $deliveryStatusInput = $thisIndex . '_delivery_status';
    
                $orderNumber = $request->$orderNumberInput;
                $createdAt = $request->$createdAtInput;
                $totalCost = $request->$totalCostInput;
                $carrier = $request->$carrierInput;
                $tracking = $request->$trackingInput;
                $deliveryStatus = $request->$deliveryStatusInput;

                if($download_type == "normal_tracking") {
                    $tmp['order_number'] = $orderNumber;
                    $tmp['created_at'] = $createdAt;
                    $tmp['total_cost'] = $totalCost;

                    if($carrier == "") {
                        $tmp['carrier'] = "N/A";
                    } else {
                        $tmp['carrier'] = $carrier;
                    }


                    if($tracking == "") {
                        $tmp['tracking'] = "N/A";
                    } else {
                        $tmp['tracking'] = $tracking;
                    }

                    if($deliveryStatus == "") {
                        $tmp['delivery_status'] = "N/A";
                    } else {
                        $tmp['delivery_status'] = $deliveryStatus;
                    }
                } else if($download_type == "bigcom_add_tracking") {
                    $tmp['order_number'] = $orderNumber;

                    if($tracking == "") {
                        $tmp['tracking_number'] = "N/A";
                    } else {
                        $tmp['tracking_number'] = strval($tracking);
                    }

                    if($carrier == "") {
                        $tmp['tracking_carrier'] = "N/A";
                    } else {
                        $thisCarrier = Carrier::where('ds_name', 'like', '%'. $carrier . '%')->first();

                        if($thisCarrier == null) {
                            $tmp['tracking_carrier'] = 'Verify tracking carrier again: ' . $carrier;
                        } else {
                            $tmp['tracking_carrier'] = $thisCarrier->bigcom_code;
                        }
                    }
                }
                
                array_push($excelArray, $tmp);
            }
        } else {
            for($i = 0; $i < $totalOrder; $i++) {
                $tmp = [];
    
                $thisIndex = $i;
                $orderNumberInput = $thisIndex . '_order_number';
                $createdAtInput = $thisIndex . '_created_at';
                $totalCostInput = $thisIndex . '_total_cost';
                $carrierInput = $thisIndex . '_carrier';
                $trackingInput = $thisIndex . '_tracking';
                $deliveryStatusInput = $thisIndex . '_delivery_status';
    
                $orderNumber = $request->$orderNumberInput;
                $createdAt = $request->$createdAtInput;
                $totalCost = $request->$totalCostInput;
                $carrier = $request->$carrierInput;
                $tracking = $request->$trackingInput;
                $deliveryStatus = $request->$deliveryStatusInput;
    
    
                $checkResult = strpos(strtolower($orderNumber), $order_type);
                if($checkResult === false) {
                    continue;
                } else {
                    if($download_type == "normal_tracking") {
                        $tmp['order_number'] = $orderNumber;
                        $tmp['created_at'] = $createdAt;
                        $tmp['total_cost'] = $totalCost;
    
                        if($carrier == "") {
                            $tmp['carrier'] = "N/A";
                        } else {
                            $tmp['carrier'] = $carrier;
                        }
    
    
                        if($tracking == "") {
                            $tmp['tracking'] = "N/A";
                        } else {
                            $tmp['tracking'] = $tracking;
                        }
    
                        if($deliveryStatus == "") {
                            $tmp['delivery_status'] = "N/A";
                        } else {
                            $tmp['delivery_status'] = $deliveryStatus;
                        }
                    } else if($download_type == "bigcom_add_tracking") {
                        $tmp['order_number'] = $orderNumber;
    
                        if($tracking == "") {
                            $tmp['tracking_number'] = "N/A";
                        } else {
                            $tmp['tracking_number'] = strval($tracking);
                        }
    
                        if($carrier == "") {
                            $tmp['tracking_carrier'] = "N/A";
                        } else {
                            $thisCarrier = Carrier::where('ds_name', 'like', '%'. $carrier . '%')->first();
    
                            if($thisCarrier == null) {
                                $tmp['tracking_carrier'] = 'Verify tracking carrier again: ' . $carrier;
                            } else {
                                $tmp['tracking_carrier'] = $thisCarrier->bigcom_code;
                            }
                        }
                    }
                }

            }
        }

        // Sort and print the resulting array
        uasort($excelArray, array( $this, 'excelCmp' ));
        
        // dd($excelArray);

        if($download_type == "normal_tracking") {
            return Excel::download(new TrackingExport($excelArray), 'ds-tracking.xlsx');
        } else if($download_type == "bigcom_add_tracking") {
            return Excel::download(new BigcomAddTrackingExport($excelArray), 'bigcom-add-tracking.csv');
        }
    }

    // Comparison function
    public function excelCmp($a, $b) {
        if ($a['order_number'] == $b['order_number']) {
            return 0;
        }
        return ($a['order_number'] < $b['order_number']) ? -1 : 1;
    }
}
