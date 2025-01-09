<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Web;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WebController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman Web Data Master
     */
    function index() : View {
        $data['webs'] = Web::select('id','nama','subdomain')->get();

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

        $newWeb = Web::create([
            'nama' => $request->nama_web,
            'subdomain' => $request->sub_domain,
        ]);

        // User::create([
        //     'desa_id' => $newWeb->id,
        //     'display_name'=> $request->namaDesa . ' - Admin',
        //     'username'=> Str::slug($request->namaDesa). '-admin',
        //     'password'=> Hash::make('admin'),
        //     'email' => Str::slug($request->namaDesa).'@gmail.com',
        //     'role' => 'Admin Desa'
        // ]);  

        // Category::create([
        //     'desa_id' => $newWeb->id,
        //     'name' => 'Tidak Berkategori',
        //     'slug' => 'uncategorized' 
        // ]);

        if ($newWeb) {
            return redirect()->route('admin.web')->with('showAlert', ['type' => 'success', 'msg' => 'Web baru berhasil ditambahkan!']);
        }else {
            return redirect()->route('admin.web')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba lagi beberapa saat.']);
        }
    }

    /**
     * (PUT)
     * Update data web
     */
    function update(Request $request, $id) : RedirectResponse {
        $request->validateWithBag('edit',[
            'nama_web' => 'required',
            'sub_domain' => 'required',
        ]);

        $web = Web::findOrFail(decrypt(base64_decode($id)));
        $arrayUpdate = [
            'nama' => $request->nama_web,
        ];

        if ($web->subdomain != $request->sub_domain) {
            $request->validateWithBag('edit',[
                'sub_domain' => 'unique:webs,subdomain',
            ]);
            $arrayUpdate['subdomain'] = $request->sub_domain;
        }

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

        if ($web->delete()) {
            return redirect()->route('admin.web')->with('showAlert', ['type' => 'success', 'msg' => 'Web berhasil dihapus!']);
        }
        
        return redirect()->route('admin.web')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba lagi beberapa saat!']);
    }

    /**
     * (GET)
     * Mengembalikan data web berdasarkan id
     */
    function web_get($id) : JsonResponse {
        $web = Web::findOrFail(decrypt(base64_decode($id)));
        return response()->json([
            'encrypted_id' => base64_encode(encrypt($web->id)),
            'nama' => $web->nama,
            'subdomain' => $web->subdomain
        ]);
    }
}
