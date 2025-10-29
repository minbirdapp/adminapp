<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'name',
        'intro',
        'industry_id',
        'competitor_info',
        'is_default'
    ];

    public function social_medias()
    {
        return $this->hasMany(BrandSocialMediaAccount::class,'brand_id');
    }
}
