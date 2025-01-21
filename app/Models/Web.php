<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Web extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

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
