<?php

namespace App\Http\Controllers\Main;

use App\Helpers\CustomHelpers;
use App\Models\Menu;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Web;
use App\Models\WebMeta;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected $web_id = 0;

    public function __construct(Request $request) {
        $this->web_id = $request->get('web_id');
    }

    /**
     * (GET)
     * Menampilkan halaman utama website
     */
    function index() : View {
        $data['web'] = Web::findOrFail($this->web_id);

        $menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['menu_html'] = CustomHelpers::build_menu_main($menu);
        
        $data['main_slide'] = WebMeta::where('web_id', $this->web_id)
                            ->where('meta_key', 'main_slide')
                            ->get();

        $data['agenda_slide'] = WebMeta::where('web_id', $this->web_id)
                            ->where('meta_key', 'agenda_slide')
                            ->get();

        $data['gallery_slide'] = WebMeta::where('web_id', $this->web_id)
                            ->where('meta_key', 'gallery_slide')
                            ->get();

        $data['partnership_slide'] = WebMeta::where('web_id', $this->web_id)
                            ->where('meta_key', 'partnership_slide')
                            ->get();
                            
        $data['categories'] = Category::with('post')
                        ->where('web_id', $this->web_id)
                        ->where('slug', '!=', 'latest-news')
                        ->orderBy('name')
                        ->get();
        
        $data['latest_news'] = Category::with('post')
                            ->where('web_id', $this->web_id)
                            ->where('slug', 'latest-news') 
                            ->first();

        return view('main.theme-1.homepage', $data);
    }

    /**
     * (GET)
     * Menampilkan halaman page berdasarkan slug
     */
    function show_page($slug) : View {
        $data['web'] = Web::findOrFail($this->web_id);

        $menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['menu_html'] = CustomHelpers::build_menu_main($menu);

        $data['page'] = Post::where('web_id', $this->web_id)
                        ->where('slug', $slug)
                        ->where('type', 'page')
                        ->where('status', 'publish')
                        ->first();
                        
        // Jika page tidak ditemukan, tampilkan halaman 404
        if (!$data['page']) {
            return abort(404);
        }

        return view('main.theme-1.page', $data);
    }

    /**
     * (GET)
     * Menampilkan halaman post berdasarkan slug
     */
    function show_post($slug) : View {
        $data['web'] = Web::findOrFail($this->web_id);

        $menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['menu_html'] = CustomHelpers::build_menu_main($menu);
        
        $data['categories'] = Category::where('web_id', $this->web_id)
                        ->orderBy('name')
                        ->get();

        $data['post'] = Post::where('web_id', $this->web_id)
                        ->where('slug', $slug)
                        ->where('type', 'post')
                        ->where('status', 'publish')
                        ->first();
        // Jika page tidak ditemukan, tampilkan halaman 404
        if (!$data['post']) {
            return abort(404);
        }

        return view('main.theme-1.post', $data);
    }
}
