<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'hero_image_1' => Setting::get('hero_image_1'),
            'hero_image_2' => Setting::get('hero_image_2'),
            'hero_image_3' => Setting::get('hero_image_3'),
            'hero_title_1' => Setting::get('hero_title_1', 'MONO+CHROME'),
            'hero_subtitle_1' => Setting::get('hero_subtitle_1', 'Ready To Wear'),
            'hero_title_2' => Setting::get('hero_title_2', 'ETHNIC ELEGANCE'),
            'hero_subtitle_2' => Setting::get('hero_subtitle_2', 'New Arrivals'),
            'hero_title_3' => Setting::get('hero_title_3', 'SUMMER BREEZE'),
            'hero_subtitle_3' => Setting::get('hero_subtitle_3', 'Casual Collection'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_image_1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'hero_image_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'hero_image_3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'hero_title_1' => 'nullable|max:255',
            'hero_subtitle_1' => 'nullable|max:255',
            'hero_title_2' => 'nullable|max:255',
            'hero_subtitle_2' => 'nullable|max:255',
            'hero_title_3' => 'nullable|max:255',
            'hero_subtitle_3' => 'nullable|max:255',
        ]);

        foreach (['hero_image_1', 'hero_image_2', 'hero_image_3'] as $field) {
            if ($request->hasFile($field)) {
                $old = Setting::get($field);
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
                $validated[$field] = $request->file($field)->store('settings', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }
}
