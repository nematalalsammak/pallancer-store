<?php

namespace App\Models;

use App\Scopes\ActiveStatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new ActiveStatusScope);
    }

    public $timestamps=false;
    public function products()
    {
        return $this->hasMany(Product::class,'category_id','id');
    }
    public function children()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id','id')->withDefault([
            'name'=>'No Parent'
        ]);

    }

}
