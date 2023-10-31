<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableOrder extends Model
{
    use HasFactory;
    protected $fillable = ['table_order_number','table_number_id', 'product_id', 'quantity'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tableOrder) {
            $tableOrder->table_order_number = 'TO' . now()->format('YmdHis');
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
