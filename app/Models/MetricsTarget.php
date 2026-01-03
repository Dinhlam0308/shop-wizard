<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetricsTarget extends Model
{
        use HasFactory;

    protected $table = 'metrics_targets';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'metric_name',
        'monthly_goal',
    ];
}
