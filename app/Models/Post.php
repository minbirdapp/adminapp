<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'title',
        'campaign_id',
        'post_type_id',
        'profile_id',
        'status',
        'schedule_date',
        'schedule_time',
        'content_type'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function postType()
    {
        return $this->belongsTo(PostType::class, 'post_type_id');
    }

    public function profile()
    {
        return $this->belongsTo(BrandSocialMediaAccount::class, 'profile_id');
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class, 'post_id');
    }

    public function contents()
    {
        return $this->hasMany(PostContent::class, 'post_id');
    }
    
}
