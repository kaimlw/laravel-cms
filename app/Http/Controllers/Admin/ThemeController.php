<?php

namespace App\Http\Controllers\Admin;

use App\Models\Media;
use App\Models\WebMeta;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\CustomHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ThemeController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman tema
     */
    function index() : View {
        $data['main_slide'] = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'main_slide')
                            ->get();

        return view('admin.theme', $data);
    }

    /**
     * (POST)
     * Menambahkan slider utama dari media_id
     */
    function store_main_slide($media_id) : JsonResponse {
        $media = Media::findOrFail($media_id);

        $newSlide = WebMeta::create([
            'web_id' => Auth::user()->web_id,
            'meta_key' => 'main_slide',
            'meta_value' => $media->media_meta['filepath']['original'],
        ]);
        
        if (!$newSlide) {
            return response()->json([
                'alert' => 'danger',
                'msg' => "Terjadi kesalahan! Coba beberapa saat lagi."
            ], 500);
        }

        return response()->json([
            'slide_id' => $newSlide->id,
            'img_path' => $media->media_meta['filepath']['original'],
        ]);
    }

    /**
     * (POST)
     * Mengupload slider utama
     */
    function upload_main_slide(Request $request) : JsonResponse {
        $request->validate([
            'upload' => 'required|mimes:png,jpg,jpeg|file|max:5000'
        ]);

        try {
            $img_path = CustomHelpers::upload_image($request->file('upload'));
        } catch (\Exception $e) {
            return response()->json([
                'alert' => 'danger',
                'msg' => $e->getMessage()
            ], 500);
        }

        $newSlide = WebMeta::create([
            'web_id' => Auth::user()->web_id,
            'meta_key' => 'main_slide',
            'meta_value' => $img_path['original'],
        ]);

        if (!$newSlide) {
            return response()->json([
                'alert' => 'danger',
                'msg' => "Terjadi kesalahan! Coba beberapa saat lagi."
            ], 500);
        }

        return response()->json([
            'slide_id' => $newSlide->id,
            'img_path' => $img_path['original']
        ]);
    }

    /**
     * (DELETE)
     * Menghapus slider utama
     */
    function destroy_main_slide($id) : RedirectResponse {
        $slide = WebMeta::findOrFail($id);

        if (!$slide->delete()) {
            return redirect()->route('admin.theme')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi.']);
        }

        return redirect()->route('admin.theme')->with('showAlert', ['type' => 'success', 'msg' => 'Slide berhasil dihapus!']);
    }
}
