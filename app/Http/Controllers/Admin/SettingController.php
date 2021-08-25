<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\_CONST;

class SettingController extends Controller
{
    // show
    public function show() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $theme = $user->theme;
        $heading = ["vietnamese" => "All settings", "english" => "Dashboard"];

        // get dashboard information
        $settings = Setting::all();

        return view('admin.web.setting.list')->with([
            'user' => $user,
            'theme' => $theme,
            'heading' => $heading,
            'settings' => $settings,
        ]);
    }

    // create
    public function create() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $theme = $user->theme;
        $heading = ["vietnamese" => "Create new setting", "english" => "Dashboard"];

        return view('admin.web.setting.create')->with([
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
        $value = $request->value;
        $encrypt = $request->encrypt;
        $description = $request->description;

        $setting = new Setting();
        $setting->name = $cname;
        $setting->description = $description;
        if($encrypt != null) {
            $setting->encrypt = 1;
            $setting->value = Crypt::encryptString($value);
        } else {
            $setting->encrypt = 0;
            $setting->value = $value;
        }
        
        $setting->save();
        $noti = 'Setting created successfully.';
        $request->session()->flash('success', $noti);
        return redirect('/admin/setting/all');
    }

    // update
    public function update($id) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $theme = $user->theme;
        $heading = ["vietnamese" => "Update setting", "english" => "Dashboard"];

        $setting = Setting::find($id);

        if($setting == null) {
            $request->session()->flash('danger', 'Setting not found.');
            return redirect()->back();
        }

        if($setting->encrypt == 1) {
            try {
                $setting->value = Crypt::decryptString($setting->value);
            } catch (DecryptException $e) {
                $request->session()->flash('warning', 'Error decrypting value for setting.');
                return redirect()->back();
            }
        }

        return view('admin.web.setting.update')->with([
            'user' => $user,
            'theme' => $theme,
            'heading' => $heading,
            'setting' => $setting
        ]);
    }

    // store update
    public function storeUpdate(Request $request, $id)
    {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $setting = setting::find($id);

        if($setting == null) {
            $request->session()->flash('danger', 'Setting part not found.');
            return redirect()->back();
        }

        $cname = $request->name;
        $value = $request->value;
        $encrypt = $request->encrypt;
        $description = $request->description;

        $setting->name = $cname;
        $setting->description = $description;
        if($encrypt != null) {
            $setting->encrypt = 1;
            $setting->value = Crypt::encryptString($value);
        } else {
            $setting->encrypt = 0;
            $setting->value = $value;
        }

        $setting->save();

        $noti = 'Setting updated successfully.';
        $request->session()->flash('success', $noti);
        return redirect('/admin/setting/all');
    }

    // delete
    public function destroy(Request $request, $id)
    {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }

        $setting = setting::find($id);
        if($setting != null) {
            $setting->delete();

            $noti = 'Deleted successfully.';
            $request->session()->flash('success', $noti);
            return redirect('/admin/setting/all');
        } else {
            $noti = 'Deleted not successfully.';
            $request->session()->flash('danger', $noti);
            return redirect('/admin/setting/all');
        }
    }
}
