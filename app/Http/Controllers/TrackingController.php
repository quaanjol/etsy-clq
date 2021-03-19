<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

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

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json'
        ])->get('https://api.dreamship.com/v1/orders', $bodyContent);

        // dd($response->body());
        return view('admin.web.tracking.result')->with([
            'result' => $response->body(),
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading
        ]);
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
}
