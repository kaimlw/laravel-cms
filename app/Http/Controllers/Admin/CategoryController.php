<?php

namespace App\Http\Controllers\Admin;

use App\Models\Web;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\CustomHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman kategori
     */
    function index() : View {
        $data['web'] = Web::findOrFail(Auth::user()->web_id)->select('site_url')->first();
        $data['categories'] = Category::select('id','name', 'slug', 'description', 'parent')
                            ->where('web_id', Auth::user()->web_id)
                            ->get();

        return view('admin.category', $data);
    }

    /**
     * (POST)
     * Menambah kategori baru
     */
    function store(Request $request) : RedirectResponse {
        $request->validateWithBag('tambah',[
            'kategori' => 'required',
        ]);

        //Cek apakah di web tersebut sudah ada kategori yang ditambahkan
        if (CustomHelpers::check_category_exist($request->kategori)) {
            return redirect()->route('admin.category')->with('showAlert', ['type' => 'danger', 'msg' => 'Kategori sudah ada!']);
        }

        $category = Category::create([
            'web_id' => Auth::user()->web_id,
            'name' => $request->kategori,
            'slug' => Str::slug($request->kategori),
            'description' => $request->deskripsi,
            'parent' => $request->parent_category
        ]);

        if ($category) {
            return redirect()->route('admin.category')->with('showAlert', ['type' => 'success', 'msg' => 'Kategori baru berhasil dibuat!']);
        }else {
            return redirect()->route('admin.category')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba lagi beberapa saat.']);
        }
    }

    /**
     * (PUT)
     * Mengedit Kategori
     */
    function update(Request $request, $id) : RedirectResponse {
        $request->validateWithBag('edit',[
            'kategori' => 'required',
        ]);

        $updateArray = [
            'description' => $request->deskripsi,
            'parent' => $request->parentCategory
        ];

        $category = Category::findOrFail($id);
        // Jika input nama kategori tidak sama dengan sebelumnya
        if ($request->kategori != $category->name) {
            // Cek jika nama kategori sudah ada 
            if (CustomHelpers::check_category_exist($request->kategori)) {
                return redirect()->route('admin.category')->with('showAlert', ['type' => 'danger', 'msg' => 'Kategori sudah ada!']);
            }
            // Masukkan nama kategori dan slug ke array update
            $updateArray['name'] = $request->kategori;
            $updateArray['slug'] = Str::slug($request->kategori);
        }

        if ($category->update($updateArray)) {
            return redirect()->route('admin.category')->with('showAlert', ['type' => 'success', 'msg' => 'Kategori berhasil diubah!']);
        }
        
        return redirect()->route('admin.category')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Silahkan coba beberapa saat lagi.']);
    }

    /**
     * (DELETE)
     * Menghapus kategori
     */
    function destroy($id) : RedirectResponse {
        $category = Category::findOrFail($id);
        // $category->post()->detach();
        if ($category->delete()) {
            return redirect()->route('admin.category')->with('showAlert', ['type' => 'success', 'msg' => 'Kategori telah berhasil dihapus!']);
        }
        
        return redirect()->route('admin.category')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Silahkan coba beberapa saat lagi.']);
    }

    /**
     * (GET)
     * Mengembalikan data kategori
     */
    function category_get($id) : JsonResponse {
        $category = Category::findOrFail($id);
        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
            'parent' => $category->parent 
        ]);
    }
}
