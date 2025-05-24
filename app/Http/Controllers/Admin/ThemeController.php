<?php

namespace App\Http\Controllers\Admin;

use App\Models\Web;
use App\Models\Media;
use App\Models\WebMeta;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\CustomHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman tema
     */
    function index() : View {
        $data['web'] = Web::findOrFail(Auth::user()->web_id)->select('site_url')->first();
        $data['main_slide'] = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'main_slide')
                            ->get();

        $data['agenda_slide'] = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'agenda_slide')
                            ->get();

        $data['gallery_slide'] = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'gallery_slide')
                            ->get();

        $data['partnership_slide'] = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'partnership_slide')
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
        
        $validator = Validator::make($request->all(), [
            'upload' => 'required|mimes:png,jpg,jpeg|file|max:5000'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'alert' => 'danger',
                'msg' => $validator->messages()->getMessages()
            ], 500);
        }

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
     * (POST)
     * Menambahkan slider utama dari media_id
     */
    function store_agenda_slide($media_id) : JsonResponse {
        $media = Media::findOrFail($media_id);

        $newSlide = WebMeta::create([
            'web_id' => Auth::user()->web_id,
            'meta_key' => 'agenda_slide',
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
    function upload_agenda_slide(Request $request) : JsonResponse {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|mimes:png,jpg,jpeg|file|max:5000'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'alert' => 'danger',
                'msg' => $validator->messages()->getMessages()
            ], 500);
        }

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
            'meta_key' => 'agenda_slide',
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
     * (POST)
     * Menambahkan slider utama dari media_id
     */
    function store_gallery_slide($media_id) : JsonResponse {
        $media = Media::findOrFail($media_id);

        $newSlide = WebMeta::create([
            'web_id' => Auth::user()->web_id,
            'meta_key' => 'gallery_slide',
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
    function upload_gallery_slide(Request $request) : JsonResponse {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|mimes:png,jpg,jpeg|file|max:5000'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'alert' => 'danger',
                'msg' => $validator->messages()->getMessages()
            ], 500);
        }

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
            'meta_key' => 'gallery_slide',
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
     * (POST)
     * Menambahkan slider utama dari media_id
     */
    function store_partnership_slide($media_id) : JsonResponse {
        $media = Media::findOrFail($media_id);

        $newSlide = WebMeta::create([
            'web_id' => Auth::user()->web_id,
            'meta_key' => 'partnership_slide',
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
    function upload_partnership_slide(Request $request) : JsonResponse {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|mimes:png,jpg,jpeg|file|max:5000'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'alert' => 'danger',
                'msg' => $validator->messages()->getMessages()
            ], 500);
        }

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
            'meta_key' => 'partnership_slide',
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
     * Menghapus slide
     */
    function destroy_slide($id) : RedirectResponse {
        $slide = WebMeta::findOrFail($id);

        if (!$slide->delete()) {
            return redirect()->route('admin.theme')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi.']);
        }

        return redirect()->route('admin.theme')->with('showAlert', ['type' => 'success', 'msg' => 'Slide berhasil dihapus!']);
    }
}
