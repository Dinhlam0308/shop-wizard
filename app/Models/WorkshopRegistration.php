<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopRegistration extends Model
{
    protected $table = 'workshop_registrations';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'workshop_id',
        'name',
        'email',
        'phone',
        'note',
        'status',
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
