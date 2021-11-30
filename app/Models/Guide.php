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

    public static function getListGuide()
    {
        return Static::paginate(8, ['id',  'guide_number',
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
        'total',]);
    }

    public static function getGuidesWithoutInvoices()
    {
        return Static::doesntHave('invoices')->get(['id',  'guide_number', 'total']);
    }

    public static function getGuidesWithInvoices()
    {
        return Static::has('invoices')->get(['id'])->toArray();
    }

    public static function getAllGuides()
    {
        return Static::all(['id',  'guide_number', 'total',]);
    }

    //foreign keys
    public function invoices()
    {
        return $this->belongsToMany('App\Models\Invoice', 'invoice_details');
    }
}
