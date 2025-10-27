<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    use HasFactory;

    protected $table = 'payment_plans';

    protected $fillable = [
        'plan_name',
        'plan_duration',
        'plan_type',
        'description',
        'no_of_brands',
        'no_of_social_accounts',
        'cost',
        'grace_duration',
        'status',
    ];
}
