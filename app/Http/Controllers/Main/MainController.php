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
        $menu = Menu::with('children')
                ->where('web_id', $this->web_id)
                ->orderBy('parent_id')
                ->orderBy('menu_order')
                ->get();
        $data['menu_html'] = CustomHelpers::build_menu_main($menu);
        
        $data['categories'] = Category::with('post')
                        ->where('web_id', $this->web_id)
                        ->where('slug', '!=', 'latest-news')
                        ->orderBy('name')
                        ->get();
        
        $data['latest_news'] = Category::with('post')
                            ->where('web_id', $this->web_id)
                            ->where('slug', 'latest-news') 
                            ->first();

        // dd($data['latest_news']);
        return view('main.theme-1.homepage', $data);
    }
}
