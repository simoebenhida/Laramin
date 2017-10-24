<?php

namespace Simoja\Laramin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Simoja\Laramin\Facades\Laramin;

class LaraminSettingsController extends Controller
{
    public function index()
    {
        if(! $this->UserCan(auth()->user()->id,'read-settings'))
            {
                abort(404);
            }
        $settings = Laramin::model('Settings')::all();
        return view('laramin::settings.index')->withSettings($settings);
    }
    public function edit(Request $request)
    {
        if(! $this->UserCan(auth()->user()->id,'update-settings'))
            {
                abort(404);
            }
        $settings = Laramin::model('Settings')::all();

        foreach ($settings as $setting) {
            if($request[$setting->key]) {
            $setting->value = $this->checkTheType($request[$setting->key],$setting);
            $setting->update();
            }
        }
        Session::flash($this->flashname,$this->SessionMessage("Your Settings Has Been Succesfully Edited",'success'));

        return redirect()->back();
    }

    public function checkTheType($request,$setting)
    {
        if($setting->type == 'image')
        {
            return $this->UploadImageSettings($request,$setting);
        }
        return $request;
    }

    public function UploadImageSettings($request,$setting)
    {
        $extension = $request->getClientOriginalExtension();
        $filename = $setting->key.'.'.$extension;
        $path = $request->storeAs('public/settings', $filename);
        return $filename;
    }
}
