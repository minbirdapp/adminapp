<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * (Optional, only needed if Laravel cannot guess it automatically)
     */
    protected $table = 'timezones';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',      // e.g. "Asia/Kolkata"
        'label',     // e.g. "GMT +5:30 (India)"
        'offset',    // e.g. "+5:30"
    ];

    /**
     * Default ordering (optional)
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
