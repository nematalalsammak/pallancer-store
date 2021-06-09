<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
    public function images()
    {
        return $this->hasMany(ProductImage::class,'product_id','id');

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

    public function getImageUrlAttribute()
    {
        if($this->image)
        {
            if(strpos($this->image,'http')=== 0){
                return $this->image;
            }
            //return asset('uploads/'. $this->image);
            //OR
            return Storage::disk('uploads')->url($this->image);
        }
        return asset('images/default-image.jpg');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name']=Str::title($value);
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
