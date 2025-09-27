<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_no',
        'item_code',
        'item_name',
        'quantity',
        'location',
        'store_name',
        'in_stock_date',
        'status',
    ];
}
