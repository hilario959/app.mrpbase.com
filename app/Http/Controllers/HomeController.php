<?php

namespace App\Http\Controllers;

use App\Material;
use App\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ordersReceived = Order::where('status', Order::STATUS_RECEIVED)->count();
        $ordersInProgress = Order::where('status', Order::STATUS_IN_PROGRESS)->count();
        $ordersDone = Order::where('status', Order::STATUS_DONE)->count();
        $materials = Material::orderBy('amount', 'asc')->get();

        return view('home', compact('ordersReceived', 'ordersInProgress', 'ordersDone', 'materials'));
    }
}
