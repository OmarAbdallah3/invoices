<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
        use HasFactory;
        use SoftDeletes;
        protected $fillable = [
            'invoice_number',
            'invoice_date',
            'due_date',
            'product',
            'section_id',
            'amount_collection',
            'amount_commission',
            'discount',
            'value_vat',
            'rate_vat',
            'total',
            'status',
            'value_status',
            'note',
            'payment_date',
        ];

        protected $dates = ['deleted_at'];
        
    public function section()
    {
        return $this->belongsTo(sections::class);
    }
    
    public function attachment():HasOne{
        return $this->hasOne(invoice_attachmentss::class);
    }

    public function details()
    {
        return $this->hasMany(invoices_details::class,'id_invoice');
    }

}
