<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function products($id)
    {
        //$tag=Tag::findOrFail($id);

        //without relationShip
        //return Product::whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id=?)',[$id])->get();

        //OR with relationShip
        //return $tag->products;
        //return $tag->products()->get();
        //return $tag->load('products.category','products.store');

        //OR
        /*$tag = Tag::with('products.category', 'products.store')->findOrFail($id);
        return $tag;*/

        //OR
        $tag = Tag::select('id', 'name')
        ->with('products:name,category_id','products.category:id,name')
        ->findOrFail($id);
        return $tag;
    }
}
