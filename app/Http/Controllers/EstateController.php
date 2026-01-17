<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EstateController extends Controller
{
    public function index()
    {
        return view('admin.estates.index', ['estates' => Estate::all(), 'types' => Estate::types()]);
    }

    public function create()
    {
        return view('admin.estates.create', ['types' => Estate::types(), 'cities' => Estate::cities()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:estates',
            'content' => 'required',
            'title_ar' => 'required|unique:estates',
            'content_ar' => 'required',
            'short' => 'nullable',
            'short_ar' => 'nullable',
            'keywords' => 'nullable',
            'keywords_ar' => 'nullable',
            'type' => 'required',
            'min' => 'nullable',
            'max' => 'nullable',
            'city' => 'required',
            'town' => 'required',
            'slug' => 'required|unique:estates',
        ]);

        $validated['slug'] = Str::slug($request->slug);

        if ($validated['min'] == '') {
            $validated['min'] = 0;
        }
        if ($validated['max'] == '') {
            $validated['max'] = 0;
        }

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {
                $image = $image->store('images\estates', 'public');
                $data[] = $image;
            }
        }

        $validated['image'] = json_encode($data);
        $estate = Estate::create($validated);

        session()->flash('success', __('admin.estate_created'));

        return redirect()->route('estates.index');
    }

    public function edit(Estate $estate)
    {
        return view('admin.estates.create', [
            'estate' => $estate,
            'images' => json_decode($estate->image),
            'types' => Estate::types(),
            'cities' => Estate::cities(),
        ]);
    }

    public function update(Request $request, Estate $estate)
    {
        $data = $request->validate([
            'title' => 'required|unique:estates,title,' . $estate->id,
            'content' => 'required',
            'title_ar' => 'required|unique:estates,title_ar,' . $estate->id,
            'content_ar' => 'required',
            'short' => 'nullable',
            'short_ar' => 'nullable',
            'keywords' => 'nullable',
            'keywords_ar' => 'nullable',
            'type' => 'required',
            'min' => 'nullable',
            'max' => 'nullable',
            'city' => 'required',
            'town' => 'required',
            'slug' => 'required|unique:estates,slug,' . $estate->id,
        ]);

        $data['slug'] = Str::slug($request->slug);

        if ($data['min'] == '') {
            $data['min'] = 0;
        }
        if ($data['max'] == '') {
            $data['max'] = 0;
        }

        $imgs = json_decode($estate->image);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {
                $image = $image->store('images\estates', 'public');
                $imgs[] = $image;
            }
        }

        $data['image'] = json_encode($imgs);
        $estate->update($data);

        session()->flash('success', __('admin.estate_updated'));

        return redirect()->route('estates.index');
    }

    public function destroy(Estate $estate)
    {
        foreach (json_decode($estate->image) as $image) {
            Storage::disk('public')->delete($image);
        }
        $estate->delete();

        return redirect()->route('estates.index');
    }

    public function towns(Request $request)
    {
        foreach (Estate::towns($request['city']) as $town) {
            $towns[] = ucfirst($town);
        }
        $response = [
            'status' => 'success',
            'towns' => $towns,
        ];

        return response()->json($response);
    }

    public function deleteImage(Request $request)
    {
        $e = Estate::find($request['estate']);
        $data = $request->validate([
            'image' => 'nullable',
        ]);

        $imgs = json_decode($e->image);
        $new = [];
        foreach ($imgs as $img) {
            if ($img != $request['img']) {
                $new[] = $img;
            } else {
                Storage::disk('public')->delete($request['img']);
            }
        }
        $data['image'] = json_encode($new);

        $e->update($data);

        $response = [
            'status' => 'success',
        ];

        return response()->json($response);
    }
}
