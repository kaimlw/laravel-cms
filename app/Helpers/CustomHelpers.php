<?php
namespace App\Helpers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CustomHelpers
{
  /**
   * Category Helper
   * Check if category with same web_id is exist in database
   */
  public static function check_category_exist($name) : Bool {
    $isExist = Category::where('web_id', Auth::user()->web_id)
              ->where('name', $name)
              ->orWhere('slug', Str::slug($name))
              ->count();
              
    return $isExist;
  }
}
?>