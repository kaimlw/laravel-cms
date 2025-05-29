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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    protected $web_id = 0;

    public function __construct(Request $request) {
        // Jika tidak ada web_id dari middleware
        if (!$request->get('web_id')) {
            // Gunakan web_id pertama dari db
            $web = Web::first();
            if ($web) {
                $this->web_id = $web->id;
            }
        } else{
            $this->web_id = $request->get('web_id');
        }
    }

    /**
     * (GET)
     * Menampilkan halaman utama website
     */
    function index() : View|RedirectResponse {
        $data['web'] = Web::findOrFail($this->web_id);

        // --- Menu Main
        $main_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'main')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['main_menu_html'] = CustomHelpers::build_menu_main($main_menu);

        // --- Menu Top
        $top_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'top')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['top_menu_html'] = CustomHelpers::build_menu_main($top_menu);

        // --- Main Slide
        $data['main_slide'] = WebMeta::where('web_id', $this->web_id)
                            ->where('meta_key', 'main_slide')
                            ->get();

        // --- Kaprodi
        $kaprodi = WebMeta::where('web_id', $this->web_id)
                            ->whereIn('meta_key', ['kaprodi_name', 'kaprodi_speech', 'kaprodi_photo'])
                            ->orderBy('meta_key', 'asc')
                            ->get();
        $data['kaprodi'] = [
            'kaprodi_name' => '',
            'kaprodi_speech' => '',
            'kaprodi_photo' => '',
        ];
        foreach ($kaprodi as $item) {
            $data['kaprodi'][$item->meta_key] = $item->meta_value;
        }

        // --- Video Profil
        $videoProfilMeta = WebMeta::where('web_id', Auth::user()->web_id)
                            ->where('meta_key', 'video_profil_link')
                            ->first();
        $data['video_profil_embed'] = "";
        if ($videoProfilMeta) {
            $data['video_profil_embed'] = CustomHelpers::generate_link_embed($videoProfilMeta->meta_value);
        }

        // --- Agenda Slide
        $data['agenda_slide'] = WebMeta::where('web_id', $this->web_id)
                            ->where('meta_key', 'agenda_slide')
                            ->get();

        // --- Gallery Slide
        $data['gallery_slide'] = WebMeta::where('web_id', $this->web_id)
                            ->where('meta_key', 'gallery_slide')
                            ->get();
        // --- Partnership Slide
        $data['partnership_slide'] = WebMeta::where('web_id', $this->web_id)
                            ->where('meta_key', 'partnership_slide')
                            ->get();
        // --- Categories
        $data['categories'] = Category::with('post')
                        ->where('web_id', $this->web_id)
                        ->where('slug', '!=', 'latest-news')
                        ->orderBy('name')
                        ->get();
        // --- Latest News
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
    function show_page($slug) : View|RedirectResponse {
        $data['web'] = Web::findOrFail($this->web_id);

        $top_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'top')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['top_menu_html'] = CustomHelpers::build_menu_main($top_menu);

        $main_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'main')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['main_menu_html'] = CustomHelpers::build_menu_main($main_menu);

        $data['page'] = Post::where('web_id', $this->web_id)
                        ->where('slug', $slug)
                        ->where('type', 'page')
                        ->where('status', 'publish')
                        ->first();
                        
        // Jika page tidak ditemukan, tampilkan halaman 404
        if (!$data['page']) {
            $data['categories'] = Category::where('web_id', $this->web_id)
                        ->orderBy('name')
                        ->get();
            return view('main.theme-1.404', $data);
        }

        return view('main.theme-1.page', $data);
    }

    /**
     * (GET)
     * Menampilkan halaman post berdasarkan slug
     */
    function show_post($slug) : View|RedirectResponse {
        $data['web'] = Web::findOrFail($this->web_id);

        $top_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'top')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['top_menu_html'] = CustomHelpers::build_menu_main($top_menu);

        $main_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'main')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['main_menu_html'] = CustomHelpers::build_menu_main($main_menu);
        
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
            return view('main.theme-1.404', $data);
        }

        return view('main.theme-1.post', $data);
    }

    /**
     * (GET)
     * Menampilkan halaman category
     */
    function show_category($slug) : View|RedirectResponse {
        $data['web'] = Web::findOrFail($this->web_id);

        $top_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'top')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['top_menu_html'] = CustomHelpers::build_menu_main($top_menu);

        $main_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'main')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['main_menu_html'] = CustomHelpers::build_menu_main($main_menu);
        
        $data['categories'] = Category::where('web_id', $this->web_id)
                        ->orderBy('name')
                        ->get();

        $data['category'] = Category::where('web_id', $this->web_id)
                        ->where('slug', $slug)
                        ->first();
        // Jika category tidak ditemukan, tampilkan halaman 404
        if (!$data['category']) {
            return view('main.theme-1.404', $data);
        }
        
        $data['posts'] = $data['category']->post()
                        ->where('status', 'publish')
                        ->orderBy('updated_at', 'desc')
                        ->get();

        return view('main.theme-1.category', $data);
    }

    /**
     * (GET)
     * Menampilkan halaman search
     */
    function show_search(Request $request) : View|RedirectResponse {
        $data['web'] = Web::findOrFail($this->web_id);

        $top_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'top')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['top_menu_html'] = CustomHelpers::build_menu_main($top_menu);

        $main_menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->where('menu_placement', 'main')
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['main_menu_html'] = CustomHelpers::build_menu_main($main_menu);

        $data['categories'] = Category::where('web_id', $this->web_id)
                        ->orderBy('name')
                        ->get();

        $data['search_keyword'] = $request->get('keyword');
        $data['posts'] = Post::where('web_id', $this->web_id)
                ->where('title', 'LIKE', '%'. $request->get('search') . '%')
                ->where('status', 'publish')
                ->orderBy('updated_at', 'desc')
                ->get();

        return view('main.theme-1.search', $data);
    }
}
