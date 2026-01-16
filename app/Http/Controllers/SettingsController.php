<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index()
    {
        return view('admin.settings.index',['settings'=>Settings::find(1)]);
    }

    public function update(Request $request)
    {
        $settings = Settings::find(1);
        $data = $request->validate([
          "facebook" => "nullable",
          "instagram" => "nullable",
          "twitter" => "nullable",
          "youtube" => "nullable",
          "telegram" => 'nullable',
          "whatsapp" => "nullable",
          "phone" => "nullable",
          "email" => "nullable",
          "desc" => "nullable",
          "desc_ar" => "nullable",
          "keywords" => "nullable",
          "keywords_ar" => "nullable"
        ]);

        $imgs = json_decode($settings->home_imgs);

        if ($request->hasFile('home_imgs')) {
          foreach($request->file('home_imgs') as $image)
          {
            $image = $image->store('images\slider','public');
            $imgs[] = $image;
          }
        }

        $data['home_imgs'] = $imgs == null  ?  ""  : json_encode($imgs);

        $settings->update($data);
        session()->flash('success', __("admin.settings_updated"));
        return redirect()->route('settings.index');
    }

    public function delete_img(Request $request)
    {
        $s = Settings::find(1);

        $data = $request->validate([
          "home_imgs" => "nullable",
        ]);

        $imgs = json_decode($s->home_imgs);
        $new = [];
        foreach ($imgs as $img) {
          if ($img != $request["img"]) {
            $new[] = $img;
          } else {
            Storage::disk('public')->delete($request["img"]);
          }
        }
        $data['home_imgs'] = json_encode($new);

        $s->update($data);

        $response = array(
          'status' => 'success',
        );
        return response()->json($response);
    }

}
