<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guide_number',
        'shipping_date',
        'country_origin',
        'sender_name',
        'sender_address',
        'sender_phone',
        'sender_email',
        'destination_country',
        'recipient_name',
        'recipient_address',
        'recipient_phone',
        'recipient_email',
        'total',
    ];
}
