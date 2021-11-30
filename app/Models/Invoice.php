<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'establishment',
        'emission_point',
        'secuencial',
        'date_issue',
        'subtotal',
        'taxes',
        'total',
        'status',
    ];

    public static function getListInvoice()
    {
        return Static::with('guides:guides.id')->paginate(8, 
        [
            'id',  
            'establishment',
            'emission_point',
            'secuencial',
            'date_issue',
            'subtotal',
            'taxes',
            'total',
            'status',
        ]);
    }

    public function guides()
    {
        return $this->belongsToMany('App\Models\Guide', 'invoice_details');
    }
}
