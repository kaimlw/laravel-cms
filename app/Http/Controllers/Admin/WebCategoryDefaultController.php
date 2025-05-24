<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\PageDefault;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryDefault;
use Illuminate\Http\RedirectResponse;

class WebCategoryDefaultController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman list default category
     * 
     * @return View
     */
    function index() : View {
        $data['categories'] = CategoryDefault::select('id','name', 'slug','description', 'parent')->get();
        return view('admin.category-default', $data);
    }

    /**
     * (POST)
     * Membuat post default baru
     */
    function store(Request $request) : RedirectResponse {
        $request->validateWithBag('tambah',[
            'name' => 'required|unique:category_defaults,name',
        ]);

        $newCategory = CategoryDefault::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->deskripsi,
            'parent' => $request->parent
        ]);
        if (!$newCategory) {
            return redirect()->route('admin.default.category')->with('showAlert', ['type' => 'danger', 'msg' => 'Gagal menambahkan kategori baru!']);
        }
        
        return redirect()->route('admin.default.category')->with('showAlert', ['type' => 'success', 'msg' => 'Kategori baru berhasil dibuat!']);
    }

    /**
     * (PUT)
     * Menyimpan perubahan halaman
     */
    function update(Request $request, $id) : RedirectResponse {
        $request->validateWithBag('edit',[
            'name' => 'required',
        ]);

        $updateArray = [
            'description' => $request->deskripsi,
            'parent' => $request->parentCategory
        ];

        $category = CategoryDefault::findOrFail($id);
        // Jika input nama kategori tidak sama dengan sebelumnya
        if ($request->name != $category->name) {
            $request->validateWithBag('edit',[
                'name' => 'unique:category_defaults,name',
            ]);
            // Masukkan nama kategori dan slug ke array update
            $updateArray['name'] = $request->name;
            $updateArray['slug'] = Str::slug($request->name);
        }

        if (!$category->update($updateArray)) {
            return redirect()->route('admin.default.category')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Silahkan coba beberapa saat lagi.']);
        }

        return redirect()->route('admin.default.category')->with('showAlert', ['type' => 'success', 'msg' => 'Kategori berhasil diubah!']);
    }

    /**
     * (DESTROY)
     * Menghapus category berdasarkan id
     */
    function destroy($id) : RedirectResponse {
        $category = CategoryDefault::findOrFail($id);

        if (!$category->delete()) {
            return redirect()->route('admin.default.category')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba lagi beberapa saat!']);
        }
        
        return redirect()->route('admin.default.category')->with('showAlert', ['type' => 'success', 'msg' => 'Halaman berhasil dihapus!']);
    }

    /**
     * (GET)
     * Mendapatkan kategori default berdasarkan id
     */
    function category_get($id) : JsonResponse {
        $category = CategoryDefault::findOrFail($id);
        return response()->json($category);
    }
}
