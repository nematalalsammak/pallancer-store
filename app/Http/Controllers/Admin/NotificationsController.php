<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $cart = Cart::with('product')
            ->where('cart_id', App::make('cart.id'))
            ->get();

        $total = $cart->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $user=Auth::user();
        $notifications=$user->notifications;

        foreach($user->notifications as $notification)
        {
            echo $notification->data['title'];
            echo $notification->data['order_id'];
            //$notification->markAsRead();
            echo $notification->created_at->diffForHumans();

        }

        /*return view('admin.notifications',[
            'cart' => $cart,
            'total' => $total,
            'notifications'=> $notifications,

    ]);*/


    }
}
