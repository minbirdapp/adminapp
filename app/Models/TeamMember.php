<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'team_member_id', // ✅ make sure this column exists in DB
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        // The one who invited (the logged-in user / tenant)
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invitedUser()
    {
        // ✅ The invited team member (record in users table)
        return $this->belongsTo(User::class, 'team_member_id');
    }

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }
}
