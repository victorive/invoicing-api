<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'user_id',
        'invoice_code',
        'amount_payable',
        'receiver_name',
        'receiver_email',
        'receiver_phone',
        'due_date',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
           $model->invoice_code = 'INV-' . substr(strtoupper(uniqid()), 0, 10);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'invoice_item',
            'invoice_id', 'item_id')
            ->withPivot(['quantity_purchased', 'amount']);
    }
}
