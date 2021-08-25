<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Carrier;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\_CONST;

class CarrierController extends Controller
{
    // show
    public function show() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $theme = $user->theme;
        $heading = ["vietnamese" => "All carriers", "english" => "Dashboard"];

        // get dashboard information
        $carriers = Carrier::all();

        return view('admin.web.carrier.list')->with([
            'user' => $user,
            'theme' => $theme,
            'heading' => $heading,
            'carriers' => $carriers,
        ]);
    }

    // create
    public function create() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $theme = $user->theme;
        $heading = ["vietnamese" => "Create new carrier", "english" => "Dashboard"];

        return view('admin.web.carrier.create')->with([
            'user' => $user,
            'theme' => $theme,
            'heading' => $heading,
        ]);
    }

    // store create
    public function store(Request $request)
    {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $cname = $request->name;
        $bigcom_name = $request->bigcom_name;
        $bigcom_code = $request->bigcom_code;
        $shopify_name = $request->shopify_name;
        $shopify_code = $request->shopify_code;
        $paypal_name = $request->paypal_name;
        $paypal_code = $request->paypal_code;

        $carrier = new Carrier();
        $carrier->name = $cname;
        $carrier->bigcom_name = $bigcom_name;
        $carrier->bigcom_code = $bigcom_code;
        $carrier->shopify_name = $shopify_name;
        $carrier->shopify_code = $shopify_code;
        $carrier->paypal_name = $paypal_name;
        $carrier->paypal_code = $paypal_code;
    
        
        $carrier->save();
        $noti = 'Carrier created successfully.';
        $request->session()->flash('success', $noti);
        return redirect('/admin/carrier/all');
    }

    // update
    public function update($id) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $theme = $user->theme;
        $heading = ["vietnamese" => "Update carrier", "english" => "Dashboard"];

        $carrier = Carrier::find($id);

        if($carrier == null) {
            $request->session()->flash('danger', 'Carrier not found.');
            return redirect()->back();
        }

        return view('admin.web.carrier.update')->with([
            'user' => $user,
            'theme' => $theme,
            'heading' => $heading,
            'carrier' => $carrier
        ]);
    }

    // store update
    public function storeUpdate(Request $request, $id)
    {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $carrier = Carrier::find($id);

        if($carrier == null) {
            $request->session()->flash('danger', 'Carrier part not found.');
            return redirect()->back();
        }

        $cname = $request->name;
        $bigcom_name = $request->bigcom_name;
        $bigcom_code = $request->bigcom_code;
        $shopify_name = $request->shopify_name;
        $shopify_code = $request->shopify_code;
        $paypal_name = $request->paypal_name;
        $paypal_code = $request->paypal_code;

        $carrier->name = $cname;
        $carrier->bigcom_name = $bigcom_name;
        $carrier->bigcom_code = $bigcom_code;
        $carrier->shopify_name = $shopify_name;
        $carrier->shopify_code = $shopify_code;
        $carrier->paypal_name = $paypal_name;
        $carrier->paypal_code = $paypal_code;
    
        $carrier->save();

        $noti = 'Carrier updated successfully.';
        $request->session()->flash('success', $noti);
        return redirect('/admin/carrier/all');
    }

    // delete
    public function destroy(Request $request, $id)
    {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $carrier = Carrier::find($id);
        if($carrier != null) {
            $carrier->delete();

            $noti = 'Deleted successfully.';
            $request->session()->flash('success', $noti);
            return redirect('/admin/carrier/all');
        } else {
            $noti = 'Deleted not successfully.';
            $request->session()->flash('danger', $noti);
            return redirect('/admin/carrier/all');
        }
    }
}
