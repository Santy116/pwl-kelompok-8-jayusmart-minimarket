<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = [
        'branch_id',
        'product_id',
        'quantity',
        'minimum_stock',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getStatusAttribute(): string
    {
        if ($this->quantity <= 0) {
            return 'Habis';
        }

        if ($this->quantity <= $this->minimum_stock) {
            return 'Menipis';
        }

        return 'Aman';
    }
}
