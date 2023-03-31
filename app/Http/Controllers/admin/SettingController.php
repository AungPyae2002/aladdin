<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $settings = Setting::where('key','home_banner_text')->get();
        $data = [];
        foreach($settings as $key=>$setting){
            $data[$setting->key] = $setting->value;
        }
        return view('admin.setting.index',[
            'settings' => $data
        ]);
    }

    public function update(Request $request)
    {
        Setting::where('key','home_banner_text')->update([
            'value' => $request->home_banner_text,
        ]);
        return redirect()->route('admin.setting.index');
    }
}
