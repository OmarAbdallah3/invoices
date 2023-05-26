<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class invoice_attachmentss extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'invoice_number',
        'created_by',
        
    ];
    
}
