<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($id)
    {
        $user=User::findOrFail($id);
        return $user->profile->first_name;

    }

    /*public function profile(Request $request,$id)
    {
        $user=User::findOrFail($id);
        $user->profile()->create([]);

        $profile=Profile::create([

        ]);

    }*/
}
