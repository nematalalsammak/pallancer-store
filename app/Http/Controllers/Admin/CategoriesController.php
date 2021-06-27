<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\WordFilter;
use App\Scopes\ActiveStatusScope;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    protected $items=[
        1=> 'Cat 1',
        'Cat 2',
        'Cat 3',
        'Cat 4',
        'Cat 5'
    ];

    public function index(Request $request)
    {
        $this->authorize('view-any',Category::class); 

        $categories=Category::when($request->name,function($query,$value){
            $query->where(function($query)use($value){
            $query->where('categories.name','LIKE',"%$value%")
            ->orWhere('categories.description','LIKE',"%$value%");
          });

        })
        ->when($request->parent_id,function($query,$value){
            $query->where('categories.parent_id','=',$value);
        
        })
        /*->leftjoin('categories as parents','parents.id','=','categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])*/
        //OR
        ->with('parent')
        //->withoutGlobalScope(ActiveStatusScope::class)
        ->get();

        //OR
        /*$query=Category::query();
        if($request->name)
        {
            $query->where(function($query)use($request){
            $query->where('name','LIKE',"%{$request->name}%")
            ->orWhere('description','LIKE',"%{$request->name}%");
          });
        }
        if($request->parent_id)
        {
            $query->where('parent_id','=',$request->parent_id);
        }
        $categories=$query->get();*/


        $parents=Category::orderBy('name','asc')->get();
        return view('admin.categories.index',[
            'categories'=>$categories,
            'parents'=>$parents,
        ]);
        //return $this->items;

    }

    public function create()
    {
        $this->authorize('create',Category::class); 

        $parents=Category::all();
        //OR
        //$parents=Category::orderBy('name','asc')->get();

        /*$title='Add Category'; 
        return view('admin.categories.create',compact('parents','title'));*/

        //OR
       /* return view('admin.categories.create')
           ->with('parents',$parents)
           ->with('title','Add Category');*/

         //OR
        return view('admin.categories.create',[
            'parents'=>$parents,
            'title'=>'Add Category',
            'category'=> new Category(),
        ]); 
    }
    public function store(Request $request)
    {
        $this->authorize('create',Category::class); 

        /*$validator=Validator::make(
            $request->all(),
            [
                'name'=>'required|max:255|unique:categories,name',
                'description'=>'nullable|min:5',
                'parent_id'=>[
                    'nullable',
                    'exists:categories,id'
            ],
                'image'=>'mimes:png,jpg',
                'status'=>'required|in:active,inactive'
            ]
            
        );

        $validator->fails();
        $validator->failed();
        $errors=$validator->errors();

        $validator->validated();*/
        $this->validateRequest($request);

        $category=new Category();
        $category->name=$request->name; //OR  $request->get('name');
        $category->slug=Str::slug($request->name);
        $category->description=$request->input('description');
        $category->parent_id=$request->post('parent_id');
        $category->status=$request->post('status');
        $category->save();

        session()->put('status','Category added from status');

        return redirect('/admin/categories')
        ->with('success','Category Added!');

        //OR
        /*session()->flash('success','Category Added!');
        return redirect('/admin/categories');*/
    }
    public function show($id)
    {
        $category = Category::findOrFail($id);

        $this->authorize('view',$category);

        return view('admin.categories.show', [
            'category' => $category,
        ]);
    }

    public function edit($id)
    {
        //$category=Category::where('id','=',$id)->first();
        //OR
        $category=Category::findOrFail($id);
        $this->authorize('update',$category);

        /*if($category == null)
        {
            abort(404);
        }*/

        $parents=Category::where('id','<>',$id)->orderBy('name','asc')->get();
        return view('admin.categories.edit',[
            'id'=>$id,
            'category'=>$category,
            'parents'=>$parents,
        ]);
    }

    public function update(Request $request,$id)
    {
        $category=Category::findOrFail($id);

        $this->authorize('update',$category);

        if($category == null)
        {
            abort(404);
        }
        $this->validateRequest($request);
        $category->name=$request->name; //OR  $request->get('name');
        $category->slug=Str::slug($request->name);
        $category->description=$request->input('description');
        $category->parent_id=$request->post('parent_id');
        $category->status=$request->post('status');
        $category->save();

        return redirect('/admin/categories')
        ->with('success','Category Updated');

    }

    public function destroy($id)
    {
        //Method 1
        $category=Category::find($id);
        $this->authorize('delete',$category);

        $category->delete();

        //OR Method 2
        //Category::where('id','=',$id)->delete();

        //OR Method 3
        //Category::destroy($id);

        return redirect('/admin/categories')
        ->with('success','Category deleted');


    }

    /*public function show($id,$title)
    {
        return $title . ':' . ($this->items[$id] ?? 'Not Found');
    }*/

    public function trash()
    {
        return view('admin.categories.trash',[
            'categories'=>Category::onlyTrashed()->paginate(),
        ]);
    }

    public function restore($id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()
        ->route('admin.categories.trash')
        ->with('success','Category restored');
    }

    public function forceDelete($id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()
        ->route('admin.categories.trash')
        ->with('success','Category deleted forever.');
    }

    public function validateRequest(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255|unique:categories,name',
                'description'=>[
                    'nullable',
                    'min:5',
                   /*function($attribute,$value,$fail){
                    if(stripos($value,'php')!==false){
                        $fail('You can not use the word "php"!');
                    }

                }*/
            new WordFilter(['php','laravel']),
            ],
                'parent_id'=>[
                    'nullable',
                    'exists:categories,id'
            ],
                'image'=>'mimes:png,jpg',
                'status'=>'required|in:active,inactive'
        ]);

       /* $validator=Validator::make([],[]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }*/

        
    }

    public function storeProduct(Request $request,$id)
    {
        $category=Category::findOrFail($id);
        $category->products()->create([
            'name'=>'Product Name',
            'price'=>10,
            
        ]);
    }
}
