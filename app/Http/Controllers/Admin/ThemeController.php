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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman tema
     */
    function index() : View {
        $data['web'] = Web::findOrFail(Auth::user()->web_id)->select('site_url')->first();
        // --- Main Slide
        $data['main_slide'] = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'main_slide')
                            ->get();
        
        // --- Kaprodi
        $kaprodi = WebMeta::where('web_id', Auth::user()->web_id)
                            ->whereIn('meta_key', ['kaprodi_name', 'kaprodi_speech', 'kaprodi_photo'])
                            ->orderBy('meta_key', 'asc')
                            ->get();
        $data['kaprodi'] = [
            'kaprodi_name' => '',
            'kaprodi_speech' => '',
            'kaprodi_photo' => '',
        ];
        foreach ($kaprodi as $item) {
            $data['kaprodi'][$item->meta_key] = $item->meta_value;
        }

        // --- Video Profil
        $videoProfilLink = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'video_profil_link')
                            ->first();
        $data['video_profil'] = [
            'video_profil_link' => '', 
            'video_profil_embed' => '',
        ];
        if ($videoProfilLink) {
            $data['video_profil']['video_profil_link'] = $videoProfilLink->meta_value;
            $data['video_profil']['video_profil_embed'] = CustomHelpers::generate_link_embed($data['video_profil']['video_profil_link']);
        }

        // --- Agenda Slide
        $data['agenda_slide'] = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'agenda_slide')
                            ->get();

        // --- Gallery Slide
        $data['gallery_slide'] = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'gallery_slide')
                            ->get();

        // --- Partnership Slide
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
     * Menyimpan nama kepala prodi dan ucapan selamat datang
     */
    function store_kaprodi_name_speech(Request $request) : RedirectResponse {
        $request->validate([
            'kaprodi_name' => 'required',
            'kaprodi_speech' => 'required'
        ]);

        try {
            DB::transaction(function() use ($request) {
                WebMeta::updateMeta("kaprodi_name", $request->kaprodi_name);
                WebMeta::updateMeta("kaprodi_speech", $request->kaprodi_speech);
            });
        } catch (\Exception $e) {
            return redirect()->route('admin.theme')->with('showAlert', ['type' => 'danger', 'msg' => $e->getMessage()]);
        }

        return redirect()->route('admin.theme')->with('showAlert', ['type' => 'success', 'msg' => 'Berhasil menyimpan perubahan!']);
    }

    /**
     * (POST)
     * Mengupload foto kaprodi
     */
    function upload_kaprodi_photo(Request $request) : JsonResponse {
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

        $newPhoto = WebMeta::updateMeta('kaprodi_photo', $img_path['original']);
        if (!$newPhoto) {
            return response()->json([
                'alert' => 'danger',
                'msg' => "Terjadi kesalahan! Coba beberapa saat lagi."
            ], 500);
        }

        return response()->json([
            'meta_id' => $newPhoto->id,
            'img_path' => $img_path['original']
        ]);
    }

    /**
     * (POST)
     * Menambahkan foto kaprodi dari media_id
     */
    function store_kaprodi_photo($media_id) : JsonResponse {
        $media = Media::findOrFail($media_id);

        $newPhoto = WebMeta::updateMeta('kaprodi_photo', $media->media_meta['filepath']['original']);
        
        if (!$newPhoto) {
            return response()->json([
                'alert' => 'danger',
                'msg' => "Terjadi kesalahan! Coba beberapa saat lagi."
            ], 500);
        }

        return response()->json([
            'slide_id' => $newPhoto->id,
            'img_path' => $media->media_meta['filepath']['original'],
        ]);
    }

    /**
     * (DELETE)
     * Menghapus meta foto kaprodi
     */
    function delete_kaprodi_photo() : RedirectResponse {
        $kaprodiPhotoMeta = WebMeta::select('id')
                            ->where('web_id',Auth::user()->web_id)
                            ->where('meta_key', 'kaprodi_photo')
                            ->first();
        if (!$kaprodiPhotoMeta->delete()) {
            return redirect()->route('admin.theme')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi.']);
        }

        return redirect()->route('admin.theme')->with('showAlert', ['type' => 'success', 'msg' => 'Foto Kaprodi berhasil dihapus!']);
    }

    /**
     * (POST)
     * Menyimpan nama kepala prodi dan ucapan selamat datang
     */
    function store_video_profil_link(Request $request) : RedirectResponse {
        $request->validate([
            'video_profil_link' => 'required',
        ]);

        $newMeta = WebMeta::updateMeta('video_profil_link', $request->video_profil_link);
        if (!$newMeta) {
            return redirect()->route('admin.theme')->with('showAlert', ['type' => 'danger', 'msg' => "Gagal menyimpan perubahan!"]);
        }
        
        return redirect()->route('admin.theme')->with('showAlert', ['type' => 'success', 'msg' => 'Berhasil menyimpan perubahan!']);
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
