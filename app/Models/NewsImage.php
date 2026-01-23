<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsImage extends Model
{
    protected $fillable = [
        'news_id',
        'image_url',
        'public_id',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
