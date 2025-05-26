<?php

namespace App\Http\Controllers\Admin;

use App\Models\Web;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class WebController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman Web Data Master
     */
    function index() : View {
        $data['webs'] = Web::select('id','name','subdomain')->get();

        return view('admin.web', $data);
    }

    /**
     * (POST)
     * Menambahkan web baru
     */
    function store(Request $request) : RedirectResponse {
        $request->validateWithBag('tambah',[
            'nama_web' => 'required',
            'sub_domain' => 'required|unique:webs,subdomain',
        ]);
        
        try {
            Web::createNewWeb($request);
        } catch (\Exception $e) {
            return redirect()->route('admin.web')->with('showAlert', ['type' => 'danger', 'msg' => $e->getMessage()]);
        }

        return redirect()->route('admin.web')->with('showAlert', ['type' => 'success', 'msg' => 'Web baru berhasil ditambahkan!']);
    }

    /**
     * (PUT)
     * Update data web
     */
    function update(Request $request, $id) : RedirectResponse {
        $web = Web::findOrFail(decrypt(base64_decode($id)));

        // Default Rules
        $validationRules = [
            'nama_web' => 'required',
            'sub_domain' => 'required',
        ];
        // Default array update
        $arrayUpdate = [
            'name' => $request->nama_web,
        ];

        // Jika subdomain beda dengan request input
        if ($web->subdomain != $request->sub_domain) {
            // Tambahkan rules dan array update
            $validationRules['sub_domain'] = 'required|unique:webs,subdomain';
            $arrayUpdate['subdomain'] = $request->sub_domain;
        }
        // Validasi $request
        $request->validateWithBag('edit', $validationRules);
        
        if ($web->update($arrayUpdate)) {
            return redirect()->route('admin.web')->with('showAlert', ['type' => 'success', 'msg' => 'Web berhasil diedit!']);            
        }
        return redirect()->route('admin.web')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Silakan coba beberapa saat lagi.']);            
    }

    /**
     * (DELETE)
     * Menghapus data web
     */
    function destroy($id) : RedirectResponse {
        $web = Web::findOrFail(decrypt(base64_decode($id)));

        if (!$web->delete()) {
            return redirect()->route('admin.web')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba lagi beberapa saat!']);
        }
        
        return redirect()->route('admin.web')->with('showAlert', ['type' => 'success', 'msg' => 'Web berhasil dihapus!']);
    }

    /**
     * (GET)
     * Mengembalikan data web berdasarkan id
     */
    function web_get($id) : JsonResponse {
        $web = Web::findOrFail(decrypt(base64_decode($id)));
        return response()->json([
            'encrypted_id' => base64_encode(encrypt($web->id)),
            'name' => $web->name,
            'subdomain' => $web->subdomain
        ]);
    }
}
