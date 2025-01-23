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
}
