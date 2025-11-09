<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandSocialMediaAccount extends Model
{
    use HasFactory;
    protected $table = 'brand_social_media_accounts';

    protected $fillable = [
        'user_id',
        'tenant_id',
        'brand_id',
        'account_type'
    ];
    public function brand()
{
    return $this->belongsTo(Brand::class, 'brand_id');
}
}
