<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $perpage=10;
    protected $fillable=[
        'name','category_id','description',
        'status','image','price','sale_price',
        'quantity','slug','store_id',
    ];

   /* protected $with =[
        'category',
        'store',
        'tags'
    ];*/
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id')->withDefault([
            'name'=>'No category'
        ]);

    }
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');

    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id',
        );
    }

    public static function validateRules()
    {
        return [
            'name'=>'required|string|max:255|min:3',
            'category_id'=>'required|exists:categories,id',
            'image'=>'image',
            'price'=>'numeric|min:0',
            'sale_price'=>['numeric','min:0',function($attr,$value,$fail){
                $price=request()->input('price');
                if($value>=$price)
                {
                    $fail($attr .' must be less than regular price');

                }

            },]
        ];
    }
}
