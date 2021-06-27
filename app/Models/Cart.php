<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Cart extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable=[
        'cart_id','user_id','product_id','quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function getTotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }

}
