<?php
namespace App\Helpers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CustomHelpers
{
  /**
   * Admin: Category Helper
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
   * Admin: Menu Helper
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
   * Main: Menu Helper
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
}
?>