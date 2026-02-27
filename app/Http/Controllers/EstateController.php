<?php

namespace App\Http\Controllers;

use App\Enums\EstateTypeEnum;
use App\Models\City;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EstateController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Estate/Index', [
            'estates' => Estate::with('city', 'town')->get(),
            'types' => EstateTypeEnum::labels(),
            'translations' => [
                'all_estates' => __('admin.all_estates'),
                'add_estate' => __('admin.add_estate'),
                'preview' => __('admin.preview'),
                'delete' => __('admin.delete'),
                'edit' => __('admin.edit'),
                'title' => __('admin.title'),
                'type' => __('admin.type'),
                'city' => __('admin.city'),
                'town' => __('admin.town'),
                'price' => __('admin.price'),
                'id' => __('admin.id'),
                'confirm_delete' => __('admin.confirm_delete'),
                'actions' => __('admin.actions'),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Estate/Create', [
            'types' => EstateTypeEnum::labels(),
            'cities' => City::all(),
            'translations' => [
                'add_estate' => __('admin.add_estate'),
                'title' => __('admin.title'),
                'en' => __('admin.en'),
                'ar' => __('admin.ar'),
                'slug' => __('admin.slug'),
                'shortmeta' => __('admin.shortmeta'),
                'keywords' => __('admin.keywords'),
                'type' => __('admin.type'),
                'min' => __('admin.min'),
                'max' => __('admin.max'),
                'city' => __('admin.city'),
                'town' => __('admin.town'),
                'price' => __('admin.price'),
                'images' => __('admin.image'),
                'content' => __('admin.content'),
                'save' => __('admin.save'),
                'create_estate' => __('admin.create_estate'),
            ],
        ]);
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
        return Inertia::render('Admin/Estate/Create', [
            'estate' => $estate,
            'types' => EstateTypeEnum::labels(),
            'cities' => City::all(),
            'translations' => [
                'add_estate' => __('admin.add_estate'),
                'edit_estate' => __('admin.edit_estate'),
                'title' => __('admin.title'),
                'en' => __('admin.en'),
                'ar' => __('admin.ar'),
                'slug' => __('admin.slug'),
                'shortmeta' => __('admin.shortmeta'),
                'keywords' => __('admin.keywords'),
                'type' => __('admin.type'),
                'min' => __('admin.min'),
                'max' => __('admin.max'),
                'city' => __('admin.city'),
                'town' => __('admin.town'),
                'price' => __('admin.price'),
                'images' => __('admin.image'),
                'content' => __('admin.content'),
                'save' => __('admin.save'),
                'update' => __('admin.update'),
                'add' => __('admin.add'),
            ],
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
        foreach ($estate->image as $image) {
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
