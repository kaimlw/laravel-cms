<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Web extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Membuat web baru serta menyimpan page, category, dan menus ke dalam web
     */
    public static function createNewWeb($request) : bool {
        $pageDefaults = PageDefault::all();
        $categoryParentDefault = CategoryDefault::whereNull('parent')->get();
        $categoryChildDefault = CategoryDefault::whereNotNull('parent')->orderBy('parent', 'asc')->get();
        $menuParentDefault = MenuDefault::whereNull('parent_id')->get();
        $menuChildDefault = MenuDefault::whereNotnUll('parent_id')->orderBy('parent_id', 'asc')->get();

        DB::transaction(function() use ($request, $pageDefaults, $categoryParentDefault, $categoryChildDefault, $menuParentDefault, $menuChildDefault) {
            $newWeb = Web::create([
                'name' => $request->nama_web,
                'subdomain' => $request->sub_domain,
                'site_url' => route('main')
            ]);

            $newUser = User::create([
                'web_id' => $newWeb->id,
                'display_name'=> $request->nama_web . ' - Admin',
                'username'=> Str::slug($request->sub_domain). '-admin',
                'password'=> Hash::make('admin'),
                'email' => Str::slug($request->sub_domain,'.').'@gmail.com',
                'roles' => 'web_admin'
            ]);

            $pageDefArray = [];
            $categoryDefArray = [];
            $menuDefArray = [];
            // Menyiapkan array untuk insert page
            foreach ($pageDefaults as $page) {
                array_push($pageDefArray, [
                    'web_id' => $newWeb->id,
                    'author' => $newUser->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'content' => '<p>Ini halaman contoh</p>',
                    'excerpt' => '<p>Ini halaman contoh</p>',
                    'type' => 'page',
                    'status' => 'publish',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
            }
            // Insert page
            $newPages = DB::table('posts')->insert($pageDefArray);

            // Menyiapkan array untuk insert category parent
            foreach ($categoryParentDefault as $category) {
                array_push($categoryDefArray, [
                    'web_id' => $newWeb->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
            }
            // Insert category parent
            $newCategories = DB::table('categories')->insert($categoryDefArray);
            // Insert category child
            $parentIds = [];
            foreach ($categoryChildDefault as $category) {
                $parentId = NULL;

                if (isset($parentIds[$category->parent])) {
                    $parentId = $parentIds[$category->parent];
                } else if ($category->parent && !isset($parentIds[$category->parent])) {
                    $parentDefault = CategoryDefault::find($category->parent);
                    $parent = Category::where('web_id', $newWeb->id)
                        ->where('slug', $parentDefault->slug)
                        ->first();
                    if ($parent) {
                        $parentId = $parent->id;
                        $parentIds[$category->parent] = $parentId;
                    }
                }

                $newMenu = Category::create([
                    'web_id' => $newWeb->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'parent' => $parentId,
                ]);
            }
            
            // Menyiapkan array untuk insert menu parent
            foreach ($menuParentDefault as $menu) {
                array_push($menuDefArray, [
                    'web_id' => $newWeb->id,
                    'name' => $menu->name,
                    'parent_id' => $menu->parent_id,
                    'type' => $menu->type,
                    'menu_order' => $menu->menu_order,
                    'menu_placement' => $menu->menu_placement,
                    'target' => $menu->target,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
            }
            // Insert menu parent
            $newMenus = DB::table('menus')->insert($menuDefArray);
            // Insert menu child 
            $parentIds = [];
            foreach ($menuChildDefault as $menu) {
                $parentId = NULL;

                if (isset($parentIds[$menu->parent_id])) {
                    $parentId = $parentIds[$menu->parent_id];
                } else if ($menu->parent && !isset($parentIds[$menu->parent_id])) {
                    $parent = Menu::where('web_id', $newWeb->id)
                        ->where('name', $menu->parent->name)
                        ->select('id')->first();
                    if ($parent) {
                        $parentId = $parent->id;
                        $parentIds[$menu->parent_id] = $parentId;
                    }
                }

                $newMenu = Menu::create([
                    'web_id' => $newWeb->id,
                    'name' => $menu->name,
                    'target' => $menu->target,
                    'type' => $menu->type,
                    'menu_order' => $menu->menu_order,
                    'menu_placement' => $menu->menu_placement,
                    'parent_id' => $parentId,
                ]);
            }
        });

        return true;      
    }

    /**
     * Modifikasi function delete() web
     */
    protected static function boot(){
        parent::boot();

        static::deleting(function ($web) {
            DB::transaction(function () use ($web){
                // Menghapus post terkait web
                foreach ($web->post as $post) {
                    // Menghapus relasi post dengan kategori
                    $post->categories()->detach();
                    $post->delete();
                }
    
                // Menghapus media terkait web
                foreach ($web->media as $media) {
                    $filepaths = $media->media_meta['filepath'];
                    // Untuk tiap path
                    foreach ($filepaths as $res => $path) {
                        // Jika file ada
                        if (File::exists(public_path($path))) {
                            // Hapus file
                            File::delete($path);
                        }
                    }
                    $media->delete();
                }

                // Menghapus kategori terkait web
                $web->category()->delete();
                // Menghapus menu terkait web
                $web->menu()->delete();
                // Menghapus web meta terkait web
                $web->web_meta()->delete();
                // Menghapus user terkait web
                $web->user()->delete();
            });
        });
    }

    /**
     * Define relation with User Table
     * Relation: (Web)One-to-Many(User)
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Define relation with Post Table
     * Relation: (Web)One-to-Many(Post)
     */
    public function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Define relation with Category Table
     * Relation: (Web)One-to-Many(Category)
     */
    public function category(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Define relation with Menu Table
     * Relation: (Web)One-to-Many(Menu)
     */
    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * Define relation with Media Table
     * Relation: (Web)One-to-Many(Media)
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Define relation with Media Table
     * Relation: (Web)One-to-Many(Media)
     */
    public function web_meta(): HasMany
    {
        return $this->hasMany(WebMeta::class);
    }
}
