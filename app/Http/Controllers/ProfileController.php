<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;
        return view('admin.profile.index',['user'=>$user,'profile'=>$profile]);
    }

    public function update(Request $request,User $user)
    {
        $user = auth()->user();
        $profile = $user->profile;
        $data = $request->validate([
          "bio" => "nullable",
          "username" => "required|unique:profiles,username,".$profile->id,
        ]);

        if ($request->hasFile("image")) {
            $image = $request['image']->store('images\profiles','public');
            Storage::disk('public')->delete($profile->image);
            $data['image'] = $image;
        }

        $profile->update($data);

        session()->flash('success', __('admin.profile_updated'));

        return redirect()->route('profile.index');
    }

}
