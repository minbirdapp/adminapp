<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';
    protected $fillable = [
        'user_id',
        'tenant_id',
        'first_name',
        'last_name',
        'brand_name',
        'brand_id',
        'industry_id',
        'brand_role_id',
        'about_brand',
        'role',
        'bio',
        'timezone_id',
        'profile_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function timezone()
    {
        return $this->belongsTo(Timezone::class);
    }
}
