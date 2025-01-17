<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\Web;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index() : View {
        if (Auth::user()->roles == 'super_admin') {
            $data['webs'] = Web::all();
            return view('admin.dashboard-super' ,$data);
        } else {
            $data['post_count'] = DB::table('posts')
                                ->selectRaw('COUNT(*) AS total_posts')
                                ->selectRaw('COUNT(CASE WHEN status = "draft" THEN 1 END) AS draft')
                                ->selectRaw('COUNT(CASE WHEN status = "publish" THEN 1 END) AS publish')
                                ->where('web_id', Auth::user()->web_id)
                                ->where('type', 'post')
                                ->get();
    
            $data['page_count'] = DB::table('posts')
                                ->selectRaw('COUNT(*) AS total_pages')
                                ->selectRaw('COUNT(CASE WHEN status = "draft" THEN 1 END) AS draft')
                                ->selectRaw('COUNT(CASE WHEN status = "publish" THEN 1 END) AS publish')
                                ->where('web_id', Auth::user()->web_id)
                                ->where('type', 'page')
                                ->get();
    
            $data['media_count'] = Media::where('web_id', Auth::user()->web_id)->count();
            $data['category_count'] = Category::where('web_id', Auth::user()->web_id)->count();
            return view('admin.dashboard-web', $data);
        }
    }
}
