<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionStoreRequest;
use App\Order;
use App\OrderProduct;
use App\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('production.index', [
            'data' => Production::paginate()
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $baseQuery = OrderProduct::where('remaining_quantity', '>', 0)
            ->select(['product_id', 'order_id']);

        $orderData = clone $baseQuery;
        $orderData->with(['product', 'order', 'order.client'])
            ->addSelect(['remaining_quantity', 'quantity']);

        $productData = clone $baseQuery;
        $productData->with('product')
            ->groupBy('product_id');

        return view('production.create', [
            'orderData' => $orderData->get(),
            'productData' => $productData->get()
        ]);
    }

    /**
     * @param ProductionStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(ProductionStoreRequest $request)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        try {
            $production = Production::create([
                'start_at' => $data['start_at'],
                'end_at' => $data['end_at']
            ]);

            $production->products()->createMany($data['products']);

            foreach ($data['products'] as $item) {
                OrderProduct::where([
                    'order_id' => $item['order_id'],
                    'product_id' => $item['product_id']
                ])->decrement('remaining_quantity', $item['quantity']);
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }

        return redirect()->route('production.index');
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
        //
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
        //
    }

    /**
     * @param Production $production
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Production $production)
    {
        \DB::beginTransaction();
        try {
            $productionProducts = $production->products()->get();

            foreach ($productionProducts as $item) {
                OrderProduct::where([
                    'order_id' => $item['order_id'],
                    'product_id' => $item['product_id']
                ])->increment('remaining_quantity', $item->quantity);

                $order = Order::find($item['order_id']);
                if ($order->status === Order::STATUS_DONE) {
                    $order->update(['status' => Order::STATUS_IN_PROGRESS]);
                }
            }

            $production->delete();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }

        return redirect()->route('production.index');
    }
}
