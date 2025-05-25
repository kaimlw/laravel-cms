<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryDefault;
use App\Models\MenuDefault;
use App\Models\PageDefault;
use App\Models\Post;
use App\Models\Web;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WebMenuDefaultController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman menu
     */
    function index(Request $request) : View {
        $data['menu_placement'] = 'main';
        // Jika ada request select menu, tampilkan menu sesuai request
        if ($request->get('select_menu')) {
            $data['menu_placement'] = $request->get('select_menu');
        }
        
        $data['menus'] = MenuDefault::with('children')
                        ->where('menu_placement', $data['menu_placement'])
                        ->orderBy('menu_order')
                        ->get();

        $data['pages'] = PageDefault::orderBy('title', 'asc')
                        ->get();

        $data['categories'] = CategoryDefault::orderBy('name', 'asc')
                            ->get();
        
        $data['menuInArray'] = [];
        $data['menu_html'] = CustomHelpers::build_menu_admin($data['menus']);
        return view('admin.menu-default', $data);
    }

    /**
     * (POST)
     * Menyimpan perubahan menu
     */
    function store(Request $request) : RedirectResponse {
        $validateRules = [
            'menu_item_title' => 'required',
            'menu_order' => 'required|integer',
            'menu_placement' => 'required'
        ];

        // Jika tipe item selain custom, tambahkan validasi tipe menu dan slug,
        // Jika tipe item custom, tambahkan validasi menu link tidak kosong
        if ($request->menu_item_type != 'custom') {
            $validateRules['menu_item_type'] = 'in:post,page,category,custom';
            $validateRules['menu_item_slug'] = 'required';
        } else {
            $validateRules['menu_item_link'] = 'required';
        }

        // Jika terdapat request parent, tambahkan validasi terdapat di menu
        if ($request->parent != null) {
            $validateRules['parent'] = 'exists:menu_defaults,id';
        }
        $request->validateWithBag("tambah", $validateRules);

        // Inisialisasi array insert
        $insertArray = [
            'name' => $request->menu_item_title,
            'parent_id' => $request->parent,
            'type' => $request->menu_item_type,
            'menu_order' => $request->menu_order,
            'menu_placement' => $request->menu_placement
        ];
        // Link menu berdasarkan tipe menu
        $link = "";
        switch ($request->menu_item_type) {
            case 'page':
                $link = '/page/' . $request->menu_item_slug;
                break;
            
            case 'category':
                $link = '/category/' . $request->menu_item_slug;
                break;
            
            default:
                $link = $request->menu_item_link;
                break;
        }
        $insertArray['target'] = $link;

        // Jika gagal membuat menu, redirect ke halaman menu dan munculkan pesan gagal
        if (!MenuDefault::create($insertArray)) {
            return redirect()->route('admin.default.menu', ['select_menu' => $request->menu_placement])->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi.']);
        }

        return redirect()->route('admin.default.menu', ['select_menu' => $request->menu_placement])->with('showAlert', ['type' => 'success', 'msg' => 'Menu berhasil ditambahkan!']);
    }

    /**
     * (PUT)
     * Menyimpan perubahan menu
     */
    function update(Request $request, $id) : RedirectResponse {
        $menu = MenuDefault::findOrFail($id);

        $request->validateWithBag('edit', [
            'menu_item_title' => 'required',
            'menu_item_link' =>' required',
            'menu_order' => 'required|integer',
        ]);
        
        $updateArray = [
            'name' => $request->menu_item_title,
            'target' => $request->menu_item_link,
            'parent_id' => $request->parent,
            'menu_order' => $request->menu_order
        ];

        if (!$menu->update($updateArray)) {
            return redirect()->route('admin.default.menu')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi.']);
        }

        return redirect()->route('admin.default.menu')->with('showAlert', ['type' => 'success', 'msg' => 'Menu berhasil diubah!']);
    }

    /**
     * (DELETE)
     * Menghapus item menu
     */
    function destroy($id) : RedirectResponse {
        $menu = MenuDefault::findOrFail($id);

        try {
            DB::transaction(function() use ($menu){
                // Jika menu memiliki children
                if ($menu->children->isNotEmpty()) {
                    $menu->children->each(function($child){
                        // Ubah parent_id children menjadi null
                        $child->parent_id = null;
                        $child->save();
                    });
                }
                
                // Hapus menu
                $menu->delete();
            });
        } catch (\Exception $e) {
            return redirect()->route('admin.default.menu')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi.']);
        }

        return redirect()->route('admin.default.menu')->with('showAlert', ['type' => 'success', 'msg' => 'Menu berhasil dihapus!']);
    }

    /**
     * (GET)
     * Mengembalikan data menu
     */
    function menu_get($id) : JsonResponse {
        $menu = MenuDefault::findOrFail($id);
        return response()->json([
            'id' => $menu->id,
            'name' => $menu->name,
            'target' => $menu->target,
            'parent_id' => $menu->parent_id,
            'menu_order' => $menu->menu_order
        ]);
    }
}
