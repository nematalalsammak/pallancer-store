<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table='stores';
    protected $primaryKey='id';
    protected $keyType='int';
    public $incrementing=true;
    public $timestamps=true;

    public function products()
    {
        return $this->hasMany(Product::class,'store_id','id');
    }
}
