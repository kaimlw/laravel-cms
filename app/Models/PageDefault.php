<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PageDefault extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Membuat page baru
     * 
     * @return array ($page, $error)
     */
    public static function createNewPage($title) : PageDefault {        
        $newPage = PageDefault::create([
            'title' => $title,
            'slug' => Str::slug($title)
        ]);

        return $newPage;
    }
}
