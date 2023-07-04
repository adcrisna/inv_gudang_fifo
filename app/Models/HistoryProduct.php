<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProduct extends Model
{
    use HasFactory;
    protected $table = 'history_product';

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function Supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }
    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

