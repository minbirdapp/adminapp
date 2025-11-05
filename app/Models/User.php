<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'activation_code_expires_at' => 'datetime', //
            'password' => 'hashed',
        ];
    }

    public function profile()
{
    return $this->hasOne(\App\Models\UserProfile::class, 'user_id');
}

public function isProfileCompleted()
{
    return $this->profile
        && !empty($this->profile->first_name)
        && !empty($this->profile->brand_name)
        && !empty($this->profile->industry_id)
        && !empty($this->profile->brand_role_id);
}

public function socialAccounts()
{
    return $this->hasMany(\App\Models\BrandSocialMediaAccount::class, 'user_id');
}
public function role()
{
    return $this->belongsTo(UserRole::class, 'user_role_id');
}
}
