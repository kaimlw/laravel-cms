<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\PageDefault;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class WebPageDefaultController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman list default page
     * 
     * @return View
     */
    function index() : View {
        $data['pages'] = PageDefault::select('id','title', 'slug')->get();
        return view('admin.page-default', $data);
    }

    /**
     * (POST)
     * Membuat post default baru
     */
    function store(Request $request) : RedirectResponse {
        $request->validateWithBag("tambah", [
            'title' => "required|unique:page_defaults,title"
        ]);

        $newPage = PageDefault::createNewPage($request->title);
        if (!$newPage) {
            return redirect()->route('admin.default.page')->with('showAlert', ['type' => 'danger', 'msg' => 'Gagal menambahkan halaman baru!']);
        }
        
        return redirect()->route('admin.default.page')->with('showAlert', ['type' => 'success', 'msg' => 'Halaman baru berhasil dibuat!']);
    }

    /**
     * (PUT)
     * Menyimpan perubahan halaman
     */
    function update(Request $request, $id) : RedirectResponse {
        $page = PageDefault::findOrFail($id);

        $request->validateWithBag('edit', [
            'title' => "required",
            'slug' => 'required'
        ]);

        $updateArray = [];
        // Jika ada perubahan title, tambahkan validasi unique
        if ($request->title != $page->title) {
            $request->validateWithBag('edit', [
                'title' => 'unique:page_defaults,title'
            ]);
            $updateArray['title'] = $request->title;
        }
        // Jika ada perubahan slug, tambahkan validasi unique
        if ($request->slug != $page->slug) {
            $request->slug = Str::slug($request->slug);
            $request->validateWithBag('edit', [
                'slug' => 'unique:page_defaults,slug'
            ]);
            $updateArray['slug'] = $request->slug;
        }

        if (!$page->update($updateArray)) {
            return redirect()->route('admin.default.page')->with('showAlert', ['type' => 'danger', 'msg' => 'Gagal menyimpan perubahan!']);
        }
        
        return redirect()->route('admin.default.page')->with('showAlert', ['type' => 'success', 'msg' => 'Halaman berhasil disimpan!']);
    }

    /**
     * (DESTROY)
     * Menghapus halaman berdasarkan id
     */
    function destroy($id) : RedirectResponse {
        $page = PageDefault::findOrFail($id);

        if (!$page->delete()) {
            return redirect()->route('admin.default.page')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba lagi beberapa saat!']);
        }
        
        return redirect()->route('admin.default.page')->with('showAlert', ['type' => 'success', 'msg' => 'Halaman berhasil dihapus!']);
    }

    /**
     * (GET)
     * Mendapatkan page default berdasarkan id
     */
    function page_get($id) : JsonResponse {
        $page = PageDefault::findOrFail($id);
        return response()->json($page);
    }
}
