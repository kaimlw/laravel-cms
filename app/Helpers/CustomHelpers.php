<?php
namespace App\Helpers;

use App\Models\Web;
use App\Models\Post;
use App\Models\User;
use App\Models\Media;
use App\Models\Category;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Database\QueryException;

class CustomHelpers
{
  /**
   * Admin: Category Helper |
   * Check if category with same web_id is exist in database
   */
  public static function check_category_exist($name) : Bool {
    $isExist = Category::where('web_id', Auth::user()->web_id)
              ->where('name', $name)
              ->orWhere('slug', Str::slug($name))
              ->count();
              
    return $isExist;
  }

  /**
   * Admin: Post Helper |
   * Add number to title if slug is exist where web_id is same
   */
  public static function add_number_if_post_title_exist($id, $title) : string {
    $post_count = Post::where('web_id', Auth::user()->web_id)
              ->where('id', '!=', $id)
              ->where(function($query) use ($title){
                $query->where('title', $title)
                ->orWhere('title', 'LIKE', $title . ' - %');
              })
              ->count();
    
    if ($post_count) {
      return $title . ' - ' . $post_count;
    }
    return $title;
  }

  /**
   * Admin: Menu Helper |
   * Build menu hierarchy to display in menu page.
   */
  public static function build_menu_admin($menus, $parent_id = null) : string {
    $result = "";

    // Menghentikan rekursif
    $children = $menus->filter(function ($menu) use ($parent_id){
      return $menu->parent_id == $parent_id;
    });

    if ($children->isNotEmpty()) {
      // Menentukan class <ul> berdasarkan parent_id 
      if ($parent_id == null) {
        $result .= '<ul class="list-unstyled">';
      } else {
        $result .= '<ul class="child-item-ul">';
      }
      
      foreach ($children as $child){
        // Menentukan class <li> berdasarkan parent_id
        if ($parent_id == null) {
          $result .= "<li class='parent-item menu-list-item'>";
        } else{
          $result .= "<li class='child-item menu-list-item'>";
        }

        // Isi <li>
        $result .= $child->name
                . "
                  <div class=''>
                      <button class='btn btn-sm btn-warning' onclick='openEditModal($child->id)'><i class='bi bi-pencil-square'></i></button>
                      <button class='btn btn-sm btn-danger' onclick='openHapusModal($child->id)'><i class='bi bi-x'></i></button>
                  </div>
              </li>  
              ";
        $result .= CustomHelpers::build_menu_admin($menus, $child->id);
      }
      $result .= '</ul>';
    }

    return $result;
  }

  /**
   * Main: Menu Helper |
   * Build menu hierarchy to display in Main Nav.
   */
  public static function build_menu_main($menu, $parent_id = null) : string {
    $result = "";

    // Menghentikan rekursif
    $children = $menu->filter(function ($menu) use ($parent_id){
      return $menu->parent_id == $parent_id;
    });

    if ($children->isNotEmpty()) {
      // Menentukan class <ul> berdasarkan parent_id 
      if ($parent_id != null) {
        $result .= '<ul class="nav-sub-menu">';
      }
      
      foreach ($children as $child){
        // Menentukan class <li> berdasarkan parent_id
        if ($parent_id == null) {
          $result .= $child->children->isEmpty() ? "<li class='nav-item'>" : "<li class='nav-item has-sub'>";
        } else{
          $result .= $child->children->isEmpty() ? "<li class='menu-item'>" : "<li class='menu-item has-sub'>";
        }

        // Isi <li>
        if ($parent_id == null) {
          $result .= "<a class='nav-link' href='$child->target'>$child->name</a>";
        } else {
          $result .= "<a href='$child->target'>$child->name</a>";
        }
        $result .= CustomHelpers::build_menu_main($menu, $child->id);
        $result .= "</li>";
      }

      if ($parent_id != null) {
        $result .= '</ul>';
      }
    }

    return $result;
  }

  /**
   * Main: Menu Helper |
   * Build menu hierarchy to display in Main Nav.
   */
  public static function build_menu_top($menu, $parent_id = null) : string {
    $result = "";

    // Menghentikan rekursif
    $children = $menu->filter(function ($menu) use ($parent_id){
      return $menu->parent_id == $parent_id;
    });

    if ($children->isNotEmpty()) {
      // Menentukan class <ul> berdasarkan parent_id 
      if ($parent_id != null) {
        $result .= '<ul class="nav-sub-menu">';
      }
      
      foreach ($children as $child){
        // Menentukan class <li> berdasarkan parent_id
        if ($parent_id == null) {
          $result .= $child->children->isEmpty() ? "<li>" : "<li class='has-sub'>";
        } else{
          $result .= $child->children->isEmpty() ? "<li class='menu-item'>" : "<li class='menu-item has-sub'>";
        }

        // Isi <li>
        $result .= "<a href='$child->target'>$child->name</a>";
        $result .= CustomHelpers::build_menu_top($menu, $child->id);
        $result .= "</li>";
      }

      if ($parent_id != null) {
        $result .= '</ul>';
      }
    }

    return $result;
  }

  /**
   * Admin: Upload Media Helper |
   * Upload Image
   * 
   * Return: Image Path (array)
   */
  public static function upload_image($file_request) : array {
    $original_name = $file_request->getClientOriginalName();
    $mime_type = $file_request->getClientMimeType();
    $size = $file_request->getSize();
    
    // Generate unique name
    $filename = uniqid() . '-' . Str::slug(explode('.', $original_name)[0]);

    try {
      // Cek apakah folder upload tersedia
      if (!is_dir(public_path('uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m')))) {
          // Buat folder
          mkdir(public_path('uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m')), 0755, true);
      }

      $original_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '.' . $file_request->getClientOriginalExtension();
      $medium_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-medium.' . $file_request->getClientOriginalExtension();        
      $thumbnail_path = 'uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/' . $filename . '-thumbnail.' . $file_request->getClientOriginalExtension();
      ImageManager::gd()->read($file_request)->scaleDown(width: 800)->save(public_path($medium_path));
      ImageManager::gd()->read($file_request)->scaleDown(width: 150)->save(public_path($thumbnail_path));

      $insertArray = [
          'web_id' => Auth::user()->web_id,
          'filename' => $filename . '.' . $file_request->getClientOriginalExtension(),
          'author' => Auth::user()->display_name,
          'media_meta' => [
              'width' => ImageManager::gd()->read($file_request)->width(),
              'height' => ImageManager::gd()->read($file_request)->height(),
              'size' => $size,
              'mime_type' => $mime_type,
              'filepath' => [
                  'original' => $original_path,
                  'medium' => $medium_path,
                  'thumbnail' => $thumbnail_path
              ]
          ]
      ];
      
      // Simpan file
      $file_request->storePubliclyAs('uploads/' . Auth::user()->web_id . '/' . date('Y') . '/' . date('m') . '/', $filename . '.' . $file_request->getClientOriginalExtension());
    } catch (\Exception $e) {
        throw $e;
    }

    try {
        Media::create($insertArray);
    } catch (QueryException $e) {
        // Untuk tiap filepath
        foreach ($insertArray['media_meta']['filepath'] as $res => $path) {
            // Jika file ada
            if (File::exists(public_path($path))) {
                // Hapus file
                File::delete($path);
            }
        }

        throw $e;
    }

    return $insertArray['media_meta']['filepath'];
  }

  /**
   * Login: Authenticate Helper |
   * Cek apakah username yang dimasukkan memiliki web_id sama
   */
  public static function check_username_in_web(string $username, int $web_id) : bool {
    $user = User::where('username', $username)->first();

    if ($user->roles == "super_admin") {
      return true;
    }
    
    return $user->web_id == $web_id;
  }

  /**
   * Login: Authenticate Helper |
   * Mendapatkan web_id dari subdomain
   */
  public static function get_webid_subdomain() : int {
    $currentUrl = url()->current();
    $host = explode('/', $currentUrl)[2];
    $host_parts = explode('.', $host);

    if (count($host_parts) >= 3) {
      $subdomain = $host_parts[0];
      $web = Web::where('subdomain', $subdomain)->first();
      if (!$web) {
          return 1;
      }
      return $web->id;
    }

    return 1;
  }

  /**
   * Theme Controller: Video Profil
   * Generate link embed youtube video dari input user
   * 
   * https://www.youtube.com/embed/ifoXe1zGk64
   * https://youtu.be/zhSSaobCq70
   * https://www.youtube.com/watch?v=zhSSaobCq70
   */
  public static function generate_link_embed(string $link) : string {
    $embed_link = "https://www.youtube.com/embed/";

    if (str_contains($link, "youtu.be")) {
      $exploded_string = explode("/", $link);
    } else if (str_contains($link, "www.youtube.com/watch")) {
      $exploded_string = explode("=", $link);
    } else if (str_contains($link, "www.youtube.com/embed")) {
      return $link;
    } else {
      return "";
    }

    $embed_code = $exploded_string[count($exploded_string)-1];
    $embed_link .= $embed_code;
    return $embed_link;
  }
}
?>