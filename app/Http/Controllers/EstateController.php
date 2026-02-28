<?php

namespace App\Http\Controllers;

use App\Enums\EstateTypeEnum;
use App\Models\City;
use App\Models\CityTown;
use App\Models\Estate;
use Exception;
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
        $valid = $request->validate([
            'title' => 'required|unique:estates',
            'content' => 'required',
            'title_ar' => 'required|unique:estates',
            'content_ar' => 'required',
            'short' => 'nullable',
            'short_ar' => 'nullable',
            'keywords' => 'nullable',
            'keywords_ar' => 'nullable',
            'type' => 'required',
            'min' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'town_id' => 'required',
            'slug' => 'required|unique:estates',
            'images' => 'nullable|array',
        ]);

        $valid['slug'] = Str::slug($valid['slug']);

        foreach ($valid['images'] ?? [] as $key => $image) {
            if ($request->hasFile('images.' . $key)) {
                $image = $image->store('estates', 'public');
                $valid['image'][] = $image;
            }
        }

        Estate::create($valid);

        return redirect()->route('estates.index')->with('success', __('admin.estate_created'));
    }

    public function edit(Estate $estate)
    {
        return Inertia::render('Admin/Estate/Create', [
            'estate' => $estate->load('city'),
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
        $valid = $request->validate([
            'title' => 'required|unique:estates,title,' . $estate->id,
            'content' => 'required',
            'title_ar' => 'required|unique:estates,title_ar,' . $estate->id,
            'content_ar' => 'required',
            'short' => 'nullable',
            'short_ar' => 'nullable',
            'keywords' => 'nullable',
            'keywords_ar' => 'nullable',
            'type' => 'required',
            'min' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'town_id' => 'required',
            'slug' => 'required|unique:estates,slug,' . $estate->id,
            'images' => 'nullable|array',
        ]);

        $valid['slug'] = Str::slug($valid['slug']);
        $valid['image'] = $estate->image;

        foreach ($valid['images'] ?? [] as $key => $image) {
            if ($request->hasFile('images.' . $key)) {
                $valid['image'][] = $image->store('estates', 'public');
            }
        }

        $estate->update($valid);

        return back()->with('success', __('admin.estate_updated'));
    }

    public function destroy(Estate $estate)
    {
        foreach ($estate->image as $image) {
            Storage::disk('public')->delete($image);
        }
        $estate->delete();

        return to_route('estates.index')->with('success', __('admin.estate_deleted'));
    }

    public function fetchTownsByCityId(Request $request)
    {
        $response = CityTown::where('city_id', $request['city'])->get();

        return response()->json($response);
    }

    public function deleteImage(Request $request, Estate $estate)
    {
        $request->validate([
            'image' => 'required',
        ]);

        try {
            Storage::disk('public')->delete($request->get('image'));

            $estate->image = array_filter($estate->image, fn ($img) => $img != $request->get('image'));
            $estate->save();
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('admin.image_deleted'),
        ]);
    }
}
