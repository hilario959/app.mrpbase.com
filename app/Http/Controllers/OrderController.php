<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Order;
use App\Product;
use DB;
class OrderController extends Controller
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
        $order = Order::all();   
        $client = Client::latest()->get();    
        return view('orders.index', compact('order', 'client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = Client::latest()->get();
        $product = Product::all();  
        return view('orders.create', compact('client','product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            //'code'=>'required',
            'client_id'=>'required',
        ]);        
        
        $order = new Order([
            'client_id' => $request->get('client_id'),
            'status' => $request->get('status'),
            'delivery_date' => $request->get('delivery_date'),
            'notes' => $request->get('notes'),
        ]);
        
        $order->save();
        
        $order->code = env("PRODUCTS_PREFIX") . $order->id;
        $order->save();

        $data=array();
        for ($i=0;$i<=count($request->product_id)-1;$i++){
            $data['order_id']=$order->id;
            $data['product_id']=$request->product_id[$i];
            $data['quantity']=$request->quantity[$i];
            $data['remaining_quantity']=$request->quantity[$i];
            $data['price']=$request->price[$i];
            DB::table('order_products')->insert($data);
        }
        return redirect('/home/order')->with('success', 'Order saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $client = Client::latest()->get();
        $product = Product::all(); 
        $order_details=DB::table('order_products')->where('order_id',$id)->get(); 
        return view('orders.edit', compact('order','client','product','order_details')); 
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
        $request->validate([
            'code'=>'required',
            'client_id'=>'required',
        ]);        

        $order = Order::find($id);
        $order->code =  $request->get('code');
        $order->client_id = $request->get('client_id');
        $order->status = $request->get('status');
        $order->delivery_date = $request->get('delivery_date');
        $order->notes = $request->get('notes');
        $order->save();   
        DB::table('order_products')->where('order_id',$id)->delete();     
        $data=array();
        for ($i=0;$i<=count($request->product_id)-1;$i++){
            $data['order_id']=$order->id;
            $data['product_id']=$request->product_id[$i];
            $data['quantity']=$request->quantity[$i];
            $data['remaining_quantity']=$request->quantity[$i];
            $data['price']=$request->price[$i];
            DB::table('order_products')->insert($data);
        }
        return redirect('/home/order')->with('success', 'Order updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();        
        return redirect('/home/order')->with('success', 'Order deleted!');
    }
}
