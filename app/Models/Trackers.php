<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Trackers extends Model
{
    use HasFactory;

    protected $table = 'trackers';

    protected $fillable = [
        'user_id',
        'tenant_id',
        'campaign_id',
        'name',
        'url',
        'status',
    ];
}
