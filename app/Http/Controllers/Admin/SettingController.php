<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Models\Web;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman setting
     */
    function index() : View {
        $data['web'] = Web::findOrFail(Auth::user()->web_id);
        return view('admin.setting', $data);
    }

    /**
     * (PUT)
     * Menyimpan perubahan setting
     */
    function update(Request $request, $id) : RedirectResponse {
        $request->validate([
            'nama_web' => 'required',
            'telepon_web' => 'required',
            'email_web' => 'email|required'
        ]);

        $web_id = decrypt(base64_decode($id));
        $web = Web::findOrFail($web_id);
        $update_array = [
            'name' => $request->nama_web,
            'phone_number' => $request->telepon_web,
            'email' => $request->email_web
        ];

        // Jika user mengganti default banner dari upload
        if ($request->banner_post_web) {
            $request->validate([
                'banner_post_web' => 'file|max:5000|mimes:png,jpg,jpeg'
            ]);

            try{
                $banner_post = CustomHelpers::upload_image($request->file('banner_post_web'));
            } catch (\Exception $e){
                return redirect()->route('admin.setting')->with('showAlert', ['type' => 'danger', 'msg' => $e->getMessage()]);
            }
            
            $update_array['default_post_banner_path'] = $banner_post['medium'];
        }

        // Jika user mengganti default banner dari media
        if ($request->banner_post_web_media) {
            $update_array['default_post_banner_path'] = $request->banner_post_web_media;
        }

        if (!$web->update($update_array)) {
            return redirect()->route('admin.setting')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi.']);
        }

        return redirect()->route('admin.setting')->with('showAlert', ['type' => 'success', 'msg' => 'Pengaturan berhasil disimpan!']);
    }

    /**
     * (PUT)
     * Hapus Gambar Banner
     */
    function set_banner_post_null(Request $request, $id) : JsonResponse {
        $request->validate([
            'banner_post_web_media' => 'required'
        ]);

        $web_id = decrypt(base64_decode($id));
        $web = Web::findOrFail($web_id);

        if (!$web->update(['default_post_banner_path' => null])) {
            return response()->json([
                'alert' => 'danger',
                'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi'
            ], 500);
        }

        return response()->json([
            'alert' => 'success',
            'msg' => 'Default banner post berhasil dihapus!'
        ]);

    }
}
