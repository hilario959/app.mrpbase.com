<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Production;
use App\OrderProduct;
use App\Order;
use App\Product;
use DB;

class ProductionController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $production = DB::table('productions')
      ->select('productions.*', 'order_products.quantity', 'order_products.remaining_quantity', 'products.name as product')
      ->join('products', 'productions.product_id', 'products.id')
      ->join('order_products', function ($join) {
        $join->on('productions.product_id', '=', 'order_products.product_id');
        $join->on('productions.order_id', '=', 'order_products.order_id');
      })
      ->groupBy('unique_id')
      ->get();

    foreach ($production as $p) {
      $serviceHistory = [];
      $unique_id = $p->unique_id;
      $serviceHistory[] = [
        "product" => $p->product,
        "quantity" => $p->quantity,
        "remaining_quantity" => $p->remaining_quantity
      ];
      $p->actions = "<a href='http://productionsoft.local/home/production/$unique_id/edit' class='btn btn-link'>View</a>";
      $p->serviceHistory = $serviceHistory;
    }
    //dd($production);
    return view('production.index', compact('production'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $orderdata = DB::table('order_products')
      ->join('orders', 'orders.id', '=', 'order_products.order_id')
      ->join('products', 'products.id', '=', 'order_products.product_id')
      ->join('clients', 'orders.client_id', '=', 'clients.id')
      ->select(
        'order_products.*',
        'orders.code',
        'products.id',
        'products.name',
        'orders.id',
        'orders.delivery_date',
        'clients.first_name',
        'clients.last_name',
        'order_products.remaining_quantity'
      )
      ->where('remaining_quantity', '!=', 0)
      ->get();
    $production = DB::table('order_products')
      ->join('products', 'products.id', '=', 'order_products.product_id')
      ->select('quantity', 'products.name', 'products.id', DB::raw('SUM(quantity) AS total_qty'))
      ->where('remaining_quantity', '!=', 0)
      ->groupBy('product_id')
      ->get();
      //dd($production);
    return view('production.create', compact('orderdata', 'production'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $postData = $_POST;
    //dd($postData);
    if (!empty($postData['order_id']) && $postData['to_be_produced'] != 0) {
      $time = time();
      $data = [];
      $orders = [];

      foreach ($postData['order_id'] as $key => $order_id) {

        if (!in_array($order_id, $orders)) {
          $orders[] = $order_id;
        }

        if (is_numeric($postData['to_be_produced'][$key]) &&  $postData['to_be_produced'][$key] > 0) {
          $data[] = [
            'order_id' => $order_id,
            'product_id' => $postData['product_id'][$key],
            'quantity' => $postData['quantity'][$key],
            'to_be_produced' => $postData['to_be_produced'][$key],
            'unique_id' => $time,
            'production_date' => $request->production_date
          ];

          $remainingquantitys = $postData['remainingquantity'][$key] - $postData['to_be_produced'][$key];


          DB::table('order_products')
            ->where('order_id', $order_id)
            ->where('product_id', $postData['product_id'][$key])
            ->update(['remaining_quantity' => $remainingquantitys]);
        }
      }
      Production::insert($data);

      foreach ($orders as $order_id) {
        //select * from order_products op where order_id = 17 and quantity > 0; 
        $counter = OrderProduct::where('order_id', $order_id)
          ->where('remaining_quantity', '>', 0)
          ->count();
        $order = Order::find($order_id);

        if ($counter > 0) {
          $order->status = 2;
        } else {
          $order->status = 3;
        }

        $order->save();
      }



      if (!empty($postData['order_id']) && $postData['to_be_produced'] != 0) {
        foreach ($postData['order_id'] as $key => $order_id) {
          if ($postData['to_be_produced'][$key]) {
            $product_id = $postData['product_id'][$key];
            $production = Production::whereRaw("order_id = $order_id AND product_id = $product_id")->first();
            //$remaining_quantity = $production->remaining_quantity > 0 ? $production->remaining_quantity : $production->remaining_quantity - $postData['to_be_produced'][$key];
            //$production->remaining_quantity = $remaining_quantity;
            $production->save();
          }
        }
      }
    }

    return redirect('/home/production')->with('success', 'Production saved!');
  }

  /**
   * Show the form for view the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($unique_id)
  {
    $production = DB::table('productions')
      ->join('products', 'products.id', '=', 'productions.product_id')
      ->select('productions.*', 'products.name', 'products.id')
      ->where('unique_id', $unique_id)
      ->get();
    return view('production.edit', compact('production'));
  }
  public function edit2($unique_id)
  {
    $orders = DB::select(DB::Raw("select o.id, o.code as 'order', concat(c.first_name, ' ', c.last_name) as client_name,
o.delivery_date as time_delivery
                                  from orders o
                                  inner join clients c on o.client_id =c.id
                                  where o.id in (
                                    select p2.order_id
                                    from productions p2
                                    where p2.unique_id = $unique_id)"
                                  )
                          );

    foreach ($orders as $o) {
      $order_id = $o->id;
      $order_products = DB::select(DB::Raw("select p.name, op.quantity, op.remaining_quantity from order_products op inner join products p on op.product_id = p.id where op.order_id = $order_id;"));
      
      $serviceHistory = [];
      $serviceHistory = $order_products;
      $o->serviceHistory = $serviceHistory;
    }

    //dd($orders);
    return view('production.edit2', compact('orders'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($unique_id)
  {
    DB::table('productions')->where('unique_id', $unique_id)->delete();
    return redirect('/home/production')->with('success', 'Production deleted!');
  }
}
