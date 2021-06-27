<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','abilities',
    ];

    protected $casts=[
        //'id'=>'int',
        //'created_at'=>'date',
        'abilities' =>'json', //OR 'array'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
