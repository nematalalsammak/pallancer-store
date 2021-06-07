<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::with('category')
        ->latest()
        ->orderBy('name','ASC')
        ->paginate(5);
        return view('admin.products.index',[
            'products'=>$products,
            'categories'=>Category::all(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create',[
            'product'=>new Product(),
            'categories'=>Category::all(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Product::validateRules());

        /*$data=$request->all();
        $data['slug']=Str::slug($data['name']);
        $product=Product::create($data);*/

        $request->merge([
            'slug'=>Str::slug($request->post('name')),
            'store_id'=> 1,
            'quantity'=>0,
        ]);
        $product=Product::create($request->all());

        //OR
        /*$product=new Product($request->all());
        $product->save();*/

        return redirect()->route('admin.products.index')
        ->with('success',"Product ($product->name) created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::findOrFail($id);
        return view('admin.products.show',[
            'product'=>$product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::findOrFail($id);
        return view('admin.products.edit',[
            'product'=>$product,
            'categories'=>Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::findOrFail($id);
        $request->validate(Product::validateRules());
        $product->update($request->all());
        //OR
        //$product->fill($request->all())->save();

        return redirect()->route('admin.products.index')
        ->with('success',"Product ($product->name) updated!");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')
        ->with('success',"Product ($product->name) deleted!");
    }
}
