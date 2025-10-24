<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandRole extends Model
{
    use HasFactory;

    protected $table = 'brand_roles';

    protected $fillable = [
        'name',
        'status',
    ];
}
