<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings', [
            'settings' => Setting::all()->keyBy('name'),
            'translations' => [
                'settings_updated' => __('admin.settings_updated'),
            ],
        ]);
    }

    public function update(SettingUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle home images upload
        $existingImages = json_decode(setting('home_imgs'), true) ?? [];

        if ($request->hasFile('home_imgs')) {
            foreach ($request->file('home_imgs') as $image) {
                $path = $image->store('images/slider', 'public');
                $existingImages[] = $path;
            }
        }

        $data['home_imgs'] = json_encode($existingImages);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['name' => $key],
                ['value' => $value]
            );
            Cache::forget('app_setting_' . $key);
        }

        session()->flash('success', __('admin.settings_updated'));

        return redirect()->route('settings.index');
    }

    public function deleteImage(Request $request): JsonResponse
    {
        $request->validate([
            'img' => ['required', 'string'],
        ]);

        $imageToDelete = $request->input('img');
        $existingImages = json_decode(setting('home_imgs'), true) ?? [];

        // Filter out the image to delete
        $updatedImages = array_values(array_filter(
            $existingImages,
            fn ($img) => $img !== $imageToDelete
        ));

        // Delete the file from storage
        if (Storage::disk('public')->exists($imageToDelete)) {
            Storage::disk('public')->delete($imageToDelete);
        }

        // Update the setting
        Setting::where('name', 'home_imgs')->update(['value' => json_encode($updatedImages)]);

        Cache::forget('app_setting_home_imgs');

        return response()->json(['status' => 'success']);
    }
}
