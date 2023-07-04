<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'invoice_item';

    protected $fillable = [
        'invoice_id',
        'item_id',
        'quantity_purchased',
        'amount',
    ];
}
