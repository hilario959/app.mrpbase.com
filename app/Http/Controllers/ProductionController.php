<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionStoreRequest;
use App\Order;
use App\OrderProduct;
use App\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
     * @param Production $production
     * @return \Illuminate\View\View
     */
    public function show(Production $production)
    {
        $productionProducts = $production->products()->with('product')->get();

        $orders = Order::whereIn('id', $productionProducts->pluck('order_id')->unique())
            ->with(['client', 'productionProducts' => function ($query) use ($production) {
                $query->where('production_id', $production->id);
            }])->get();

        return view('production.show', [
            'production' => $production,
            'productionProducts' => $productionProducts,
            'orders' => $orders
        ]);
    }

    /**
     * @param Production $production
     * @return \Illuminate\View\View
     */
    public function edit(Production $production)
    {
        $baseQuery = $production->products()
            ->with(['product']);

        $productionData = clone $baseQuery;
        $productionData->with(['order', 'order.client'])
            ->productQuantities();

        $productData = clone $baseQuery;
        $productData->groupBy('product_id');

        return view('production.edit', [
            'production' => $production,
            'productionData' => $productionData->get(),
            'productData' => $productData->get()
        ]);
    }

    /**
     * @param ProductionStoreRequest $request
     * @param Production $production
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(ProductionStoreRequest $request, Production $production)
    {
        $requestData = $request->validated();

        \DB::beginTransaction();
        try {
            $production = $production->fill([
                'start_at' => $requestData['start_at'],
                'end_at' => $requestData['end_at']
            ]);
            $production->save();

            /** @var Collection $productionProducts */
            $productionProducts = $production->products;

            foreach ($productionProducts as $item) {
                $newQuantity = ($requestData['products'][$item->id]['quantity'] ?? 0) - $item->quantity;

                $orderProduct = OrderProduct::where([
                    'order_id' => $item->order_id,
                    'product_id' => $item->product_id
                ])->first();

                $orderProduct->remaining_quantity -= $newQuantity;
                $orderProduct->save();

                if ($orderProduct->remaining_quantity !== 0 && $orderProduct->order->status === Order::STATUS_DONE) {
                    $orderProduct->order->update(['status' => ORDER::STATUS_IN_PROGRESS]);
                }
            }

            $production->products()->delete();
            $production->products()->createMany($requestData['products']);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            throw $e;
        }

        return redirect()->route('production.index');
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
