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

          $production =DB::table('productions')
        ->select('productions.*')
        ->groupBy('unique_id')
        ->get();
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
         ->select('order_products.*', 'orders.code', 'products.id','products.name','orders.id')
         ->where('remaining_quantity', '!=' ,0)
         ->get();
         $production = DB::table('order_products')
         ->join('products', 'products.id', '=', 'order_products.product_id')
         ->select('quantity', 'products.name', DB::raw('SUM(quantity) AS total_qty'))
         ->where('remaining_quantity', '!=' ,0)
         ->groupBy('product_id')
         ->get();
        return view('production.create', compact('orderdata','production'));
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
        if(!empty($postData['order_id']) && $postData['to_be_produced'] !=0)
        {
            $time = time();
            $data = [];
            foreach($postData['order_id'] as $key => $order_id){
                if($postData['to_be_produced'][$key]){
                    $data[] = [
                    'order_id' => $order_id,
                    'product_id' => $postData['product_id'][$key],
                    'quantity' => $postData['quantity'][$key],
                    'to_be_produced' => $postData['to_be_produced'][$key],
                    'unique_id' => $time
                ];
                   $remainingquantitys=$postData['remainingquantity'][$key]-$postData['to_be_produced'][$key];

                 DB::table('order_products')
                ->where('order_id', $order_id)
                ->update(['remaining_quantity' =>$remainingquantitys]);
                }
            }
            Production::insert($data);

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
         ->select('productions.*','products.name','products.id')
         ->where('unique_id',$unique_id)
         ->get();
         return view('production.edit', compact('production'));
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
