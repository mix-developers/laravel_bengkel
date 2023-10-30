<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'customer') {
            $order = Order::where('id_user', Auth::user()->id)->latest()->get();
        } else {
            $order = Order::latest()->get();
        }
        $data = [
            'title' => 'Data Order',
            'order' => $order,
        ];
        return view('pages.order.index', $data);
    }
}
