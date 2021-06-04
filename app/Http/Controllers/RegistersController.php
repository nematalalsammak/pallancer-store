<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Rules\RegisterFilter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class RegistersController extends Controller
{
    public function create()
    {
        $userinfo=Register::all();
        return view('register',[
            'userinfo'=>$userinfo,
            'register'=>new Register(),
        ]); 
    }
    public function store(Request $request)
    {
        /*$postDate=$this->validate($request,[
            'name'=>'required|max:255',
                'email'=>'required|email|unique:registers,email',
                'password'=>'required',
                'gender'=>'required|in:male,female',
                'birthday'=>'required|date_format:Y-m-d',
                'phone'=>'nullable|size:10',
        ]);*/
        //$dob=Carbon::parse('$postDate')->age;


        /*$dt=new Carbon();
        $before=$dt->subYears(14)->format('Y-m-d');*/

        $request->validate([
                'name'=>'required|max:255',
                'email'=>'required|email|unique:registers,email',
                'password'=>'required',
                'gender'=>'required|in:male,female',
                /*'birthday'=>[
                    'required',
                    'date',
                    'before:2007-01-01',
                    new RegisterFilter(),
                ],
                'birthday'=>'olderThan:15',
                'birthday'=>'required|date|before:'.$before,*/
                'birthday'=>'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(14)->format('Y-m-d'),
                'phone'=>[
                    'required',
                    'size:10',
                    'regex:/^(059|056)([0-9]{7})$/',
                ],
        ]);

        /*$validator=Validator::make(
            $request->all(),
            [
                'name'=>'required|max:255',
                'email'=>'required|email|unique:registers,email',
                'password'=>'required',
                'gender'=>'required|in:male,female',
                'birthday'=>'',
                'phone'=>'nullable|max:10',
            ]
            
        );

        $clean=$validator->validated();*/

        

        $register=new Register();
        $register->name=$request->name; //OR  $request->get('name');
        //OR
        //$register->name=$clean['name'];

        $register->slug=Str::slug($request->name);
        $register->email=$request->input('email');
        $register->password=$request->post('password');
        $register->gender=$request->post('gender');
        $register->birthday=$request->post('birthday');
        $register->phone=$request->post('phone');

        $register->save();

        /*return redirect('/register')
        ->with('success','User Added!');*/

        //OR
        /*session()->flash('success','User Added!');
        return redirect('/register');*/

        //OR
        return redirect('/register')->with('success','Register Successfully');
    }
}
