<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'campaigns';

    protected $fillable = [
        'user_id',
        'tenant_id',
        'brand_id',
        'name',
        'objective',
        'notes',
        'start_date',
        'end_date',
        'status',
    ];

     public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function trackingUrls()
    {
        return $this->hasMany(Trackers::class);
    }

}
