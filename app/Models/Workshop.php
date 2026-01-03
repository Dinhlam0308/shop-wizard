<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $table = 'workshops';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'max_participants',
        'price',
        'location',
        'image',
        'public_id',
    ];

    public function registrations()
    {
        return $this->hasMany(WorkshopRegistration::class);
    }
}
