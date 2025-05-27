<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebMeta extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Function menyimpan web meta baru
     */
    public static function saveMeta($meta_key, $meta_value) : WebMeta|null {
        $newMeta = WebMeta::create([
            'web_id' => Auth::user()->web_id,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value,
        ]);
        if (!$newMeta) {
            return null;
        }
        return  $newMeta;
    }

    /**
     * Function mengganti web meta terbaru
     */
    public static function updateMeta($meta_key, $meta_value) : WebMeta|null {
        $meta_exist = WebMeta::select('id')
                    ->where('web_id', Auth::user()->web_id)
                    ->where('meta_key', $meta_key)
                    ->first();
        if ($meta_exist) {
            $meta_exist->delete();
        }

        $newMeta = WebMeta::saveMeta($meta_key, $meta_value);
        if (!$newMeta) {
            return null;
        }
        
        return $newMeta;
    }

    /**
     * Define relation with Webs Table
     * Relation: (Web)One-to-Many(Media)
     */
    public function web(): BelongsTo
    {
        return $this->belongsTo(Web::class);
    }
}
