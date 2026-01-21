<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
        'public_id',
        'available',
        'is_featured',
        'is_special',
    ];
}
