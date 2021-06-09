<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $products = Product::with('category')
            ->latest()
            ->orderBy('name', 'ASC')
            ->paginate(5);
        return view('admin.products.index', [
            'products' => $products,
            'categories' => Category::all(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create', [
            'product' => new Product(),
            'categories' => Category::all(),

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

        $request->merge([
            'slug' => Str::slug($request->post('name')),
            'store_id' => 1,
            'quantity' => 0,
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->store('/');
        }

        /*$data=$request->all();
        $data['slug']=Str::slug($data['name']);
        $product=Product::create($data);*/


        $product = Product::create($data);

        //OR
        /*$product=new Product($request->all());
        $product->save();*/

        return redirect()->route('admin.products.index')
            ->with('success', "Product ($product->name) created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', [
            'product' => $product,
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
        $product = Product::findOrFail($id);
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
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
        $product = Product::findOrFail($id);
        $request->validate(Product::validateRules());

        $data = $request->all();
        
        $previous=false;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            //store in local disk
            //$data['image'] = $file->store('/images');

            //store in public disk
            //$data['image'] = $file->store('/images','public');
            //OR
            $data['image'] = $file->store('/images',[
                'disk' => 'uploads',
            ]);

            //$file->move(public_path('/images'), uniqid() . '.' . $file->getClientOriginalExtension());
            //OR
            /*$data['image'] = $file->storeAs('/images', $file->getClientOriginalName(), [
                'disk' => 'uploads',
            ]);*/

            $previous=$product->image;
        }
        $product->update($data);
        //OR
        //$product->fill($request->all())->save();

        if($previous){
            Storage::disk('uploads')->delete($previous);
        }

        //Gallery(multiple file)
        if($request->hasFile('gallery')){
            foreach($request->file('gallery')as $file){
               $image_path = $file->store('/images',[
                    'disk' => 'uploads',
                ]);
               /* $product->images()->create([
                    'image_path'=>$image_path,
                ]);*/
                //OR
                $image=new ProductImage([
                    'image_path'=>$image_path,
                ]);
                $product->images()->save($image);
            }
        }
        


        return redirect()->route('admin.products.index')
            ->with('success', "Product ($product->name) updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        if($product->image)
        {
            Storage::disk('uploads')->delete($product->image);
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Product ($product->name) deleted!");
    }
}
