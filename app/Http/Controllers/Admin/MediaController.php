<?php

namespace App\Http\Controllers\Admin;

use App\Models\Web;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;

class MediaController extends Controller
{
    protected $documentTypes = [
        "image" => [
            "image/jpeg",
            "image/png",
        ],
        "spreadsheets" => [
            "application/vnd.apple.numbers",
            "application/vnd.oasis.opendocument.spreadsheet",
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-excel.sheet.macroEnabled.12",
            "application/vnd.ms-excel.sheet.binary.macroEnabled.12",
        ],
        "documents" => [
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.ms-word.document.macroEnabled.12",
            "application/vnd.ms-word.template.macroEnabled.12",
            "application/vnd.oasis.opendocument.text",
            "application/vnd.apple.pages",
            "application/pdf",
            "application/vnd.ms-xpsdocument",
            "application/oxps",
            "application/rtf",
            "application/wordperfect",
            "application/octet-stream",
        ],
    ];

    /**
     * (GET)
     * Menampilkan halaman media
     */
    function index(Request $request) : View {
        $data['web'] = Web::findOrFail(Auth::user()->web_id)->select('site_url')->first();

        $media_query = Media::where('web_id', Auth::user()->web_id);
        $data['filter'] = [
            "file_type" => null,
            "file_date" => null,
            "file_search" => null,
        ];
        // If there is file_type request
        if ($request->get('file_type') && $request->get('file_type') != 'all') {
            $media_query = $media_query->whereIn('media_meta->mime_type', $this->documentTypes[$request->get('file_type')]);
            $data['filter']['file_type'] = $request->get('file_type');
        }
        // If there is file_date request
        if ($request->get('file_date') && $request->get('file_date') != 'all') {
            $month = explode('-', $request->get('file_date'))[0]; 
            $year = explode('-', $request->get('file_date'))[1]; 
            $media_query = $media_query->whereYear('created_at', $year)->whereMonth('created_at', $month);
            $data['filter']['file_date'] = $request->get('file_date');
        }
        // If there is file_search request
        if ($request->get('file_search') && $request->get('file_search') != null) {
            $media_query = $media_query->where('filename', "LIKE", "%" . $request->get('file_search') . '%');
            $data['filter']['file_search'] = $request->get('file_search');
        }
        $data['media'] = $media_query->orderBy('created_at', 'desc')
                        ->limit(30)
                        ->get();

        $data['media_count'] = $media_query->count();
        $data['media_date_group'] = Media::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month")
                                    ->where('web_id', Auth::user()->web_id)
                                    ->groupBy('year', 'month')
                                    ->orderBy('year', 'desc')
                                    ->orderBy('month','desc')
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
                $medium_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-medium.' . $file->getClientOriginalExtension();        
                $thumbnail_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-thumbnail.' . $file->getClientOriginalExtension();        
                
                ImageManager::gd()->read($file)->scaleDown(width: 800)->save(public_path($medium_path));
                ImageManager::gd()->read($file)->scaleDown(width: 150)->save(public_path($thumbnail_path));
                
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
     * (GET)
     * Mengembalikan data media per offset
     */
    function media_load(Request $request) : JsonResponse {
        $media_query = Media::where('web_id', Auth::user()->web_id);
        // If there is file_type request
        if ($request->post('file_type') && $request->post('file_type') != 'all') {
            $media_query = $media_query->whereIn('media_meta->mime_type', $this->documentTypes[$request->get('file_type')]);
        }
        // If there is file_date request
        if ($request->post('file_date') && $request->post('file_date') != 'all') {
            $month = explode('-', $request->post('file_date'))[0]; 
            $year = explode('-', $request->post('file_date'))[1]; 
            $media_query = $media_query->whereYear('created_at', $year)->whereMonth('created_at', $month);
        }
        // If there is file_search request
        if ($request->post('file_search') && $request->post('file_search') != null) {
            $media_query = $media_query->where('filename', "LIKE", "%" . $request->post('file_search') . '%');
        }

        $media = $media_query
                ->offset($request->offset)
                ->limit(10)
                ->orderBy('created_at', 'desc')
                ->get();

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
            $medium_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-medium.' . $file->getClientOriginalExtension();        
            $thumbnail_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-thumbnail.' . $file->getClientOriginalExtension();
            ImageManager::gd()->read($file)->scaleDown(width: 800)->save(public_path($medium_path));
            ImageManager::gd()->read($file)->scaleDown(width: 150)->save(public_path($thumbnail_path));

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
            'url' => asset($insertArray['media_meta']['filepath']['original'])
        ]);
    }
}
