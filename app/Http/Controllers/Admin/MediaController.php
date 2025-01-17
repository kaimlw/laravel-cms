<?php

namespace App\Http\Controllers\Admin;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;

class MediaController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman media
     */
    function index() : View {
        $data['media'] = Media::where('web_id', Auth::user()->web_id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.media', $data);
    }

    /**
     * (POST)
     * Menyimpan media
     */
    function store(Request $request) : RedirectResponse {
        $request->validate([
            'media' => 'required|file|max:128000|mimes:png,jpg,jpeg,pdf,docx,xls,xlsx'
        ]);

        $file = $request->file('media');
        $original_name = $file->getClientOriginalName();
        $mime_type = $file->getClientMimeType();
        $size = $file->getSize();
        
        // Generate unique name
        $filename = uniqid() . '-' . Str::slug(explode('.', $original_name)[0]);

        try {
            // Cek apakah folder upload tersedia
            if (!is_dir(public_path('uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m')))) {
                // Buat folder
                mkdir(public_path('uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m')), 0755, true);
            }

            $original_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '.' . $file->getClientOriginalExtension();
            $insertArray = [
                'web_id' => Auth::user()->web_id,
                'filename' => $filename . '.' . $file->getClientOriginalExtension(),
                'author' => Auth::user()->display_name,
                'media_meta' => [
                    'size' => $size,
                    'mime_type' => $mime_type,
                    'filepath' => [
                        'original' => $original_path,
                    ]
                ]
            ];
            
            // Cek apakah file termasuk image
            if (strpos($file->getMimeType(), 'image/') === 0) {
                $medium_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-800x800.' . $file->getClientOriginalExtension();        
                $thumbnail_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-150x150.' . $file->getClientOriginalExtension();        
                
                ImageManager::gd()->read($file)->resizeDown(800,800)->save(public_path($medium_path));
                ImageManager::gd()->read($file)->resizeDown(150,150)->save(public_path($thumbnail_path));
                
                $insertArray['media_meta']['width'] = ImageManager::gd()->read($file)->width();
                $insertArray['media_meta']['height'] = ImageManager::gd()->read($file)->height();
                $insertArray['media_meta']['filepath']['medium'] = $medium_path;
                $insertArray['media_meta']['filepath']['thumbnail'] = $thumbnail_path;
            }
            
            // Simpan file
            $file->storePubliclyAs('uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/', $filename . '.' . $file->getClientOriginalExtension());
        } catch (\Exception $e) {
            return redirect()->route('admin.media')->with('showAlert', ['type' => 'danger', 'msg' => $e->getMessage()]);
        }

        if (!Media::create($insertArray)) {
            return redirect()->route('admin.media')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi.']);
        }
        return redirect()->route('admin.media')->with('showAlert', ['type' => 'success', 'msg' => 'Media berhasil diunggah!']);
    }

    /**
     * (DELETE)
     * Menghapus media
     */
    function destroy($id) : RedirectResponse {
        $media = Media::findOrFail($id);

        try {
            // Mendapatkan filepath media
            $filePath = $media->media_meta['filepath'];

            // Untuk tiap filepath
            foreach ($filePath as $res => $path) {
                // Jika file ada
                if (File::exists(public_path($path))) {
                    // Hapus file
                    File::delete($path);
                }
            }

            $media->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.media')->with('showAlert', ['type' => 'danger', 'msg' => $e->getMessage()]);
        }

        return redirect()->route('admin.media')->with('showAlert', ['type' => 'success', 'msg' => 'Media berhasil dihapus!']);
    }

    /**
     * (GET)
     * Mengembalikan data media
     * Jika $id = "all", Mengembalikan semua media web
     * Jika $id != "all", Mengembalikan media sesuai id
     */
    function media_get($id) : JsonResponse {
        if ($id == 'all') {
            $media = Media::where('web_id', Auth::user()->web_id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else{
            $media = Media::findOrFail($id);
        }

        return response()->json($media);
    }

    /**
     * (POST)
     * Mengunggah gambar dari text editor CKEditor
     */
    function upload_image(Request $request) : JsonResponse {
        $request->validate([
            'upload' => 'required|file|max:128000|mimes:png,jpg,jpeg'
        ]);

        $insertArray = [];
        
        $file = $request->file('upload');
        $original_name = $file->getClientOriginalName();
        $mime_type = $file->getClientMimeType();
        $size = $file->getSize();
        
        // Generate unique name
        $filename = uniqid() . '-' . Str::slug(explode('.', $original_name)[0]);

        try {
            // Cek apakah folder upload tersedia
            if (!is_dir(public_path('uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m')))) {
                // Buat folder
                mkdir(public_path('uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m')), 0755, true);
            }

            $original_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '.' . $file->getClientOriginalExtension();
            $medium_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-800x800.' . $file->getClientOriginalExtension();        
            $thumbnail_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-150x150.' . $file->getClientOriginalExtension();
            ImageManager::gd()->read($file)->resizeDown(800,800)->save(public_path($medium_path));
            ImageManager::gd()->read($file)->resizeDown(150,150)->save(public_path($thumbnail_path));

            $insertArray = [
                'web_id' => Auth::user()->web_id,
                'filename' => $filename . '.' . $file->getClientOriginalExtension(),
                'author' => Auth::user()->display_name,
                'media_meta' => [
                    'width' => ImageManager::gd()->read($file)->width(),
                    'height' => ImageManager::gd()->read($file)->height(),
                    'size' => $size,
                    'mime_type' => $mime_type,
                    'filepath' => [
                        'original' => $original_path,
                        'medium' => $medium_path,
                        'thumbnail' => $thumbnail_path
                    ]
                ]
            ];
            
            // Simpan file
            $file->storePubliclyAs('uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/', $filename . '.' . $file->getClientOriginalExtension());
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }

        try {
            Media::create($insertArray);
        } catch (QueryException $e) {
            // Untuk tiap filepath
            foreach ($insertArray['media_meta']['filepath'] as $res => $path) {
                // Jika file ada
                if (File::exists(public_path($path))) {
                    // Hapus file
                    File::delete($path);
                }
            }
            return response()->json([
                'error' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }

        return response()->json([
            'url' => asset($insertArray['media_meta']['filepath']['medium'])
        ]);
    }
}
