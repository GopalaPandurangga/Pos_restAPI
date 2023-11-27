<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ["id"];


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_number');
    }

    public function orderDetail()
    {
        return $this->hasmany(OrderDetails::class, 'order_id');
    }
}
