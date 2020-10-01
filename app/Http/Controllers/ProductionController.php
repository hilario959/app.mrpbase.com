<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionStoreRequest;
use App\Inventory;
use App\Material;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Production;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        $productData->with(['product', 'product.materials'])->groupBy('product_id');
        $productData = $productData->get();

        $materials = Material::whereIn(
            'id',
            \DB::table('material_product')->whereIn('product_id', $productData->pluck('product_id'))
                ->pluck('material_id')
        )->get();

        return view('production.create', [
            'orderData' => $orderData->get(),
            'productData' => $productData,
            'materials' => $materials
        ]);
    }

    /**
     * @param ProductionStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(ProductionStoreRequest $request)
    {
        $requestData = $request->validated();

        \DB::beginTransaction();
        try {
            $production = Production::create([
                'start_at' => $requestData['start_at'],
                'end_at' => $requestData['end_at']
            ]);

            $production->products()->createMany($requestData['products']);

            $orderIds = [];
            $productsQuantity = [];
            foreach ($requestData['products'] as $item) {
                $orderIds[] = $item['order_id'];
                OrderProduct::where([
                    'order_id' => $item['order_id'],
                    'product_id' => $item['product_id']
                ])->decrement('remaining_quantity', $item['quantity']);

                $productsQuantity[$item['product_id']] = $item['quantity'];
            }

            $materialProduct = DB::table('material_product')
                ->whereIn('product_id', array_column($requestData['products'], 'product_id'))
                ->get();

            $materials = [];
            foreach ($materialProduct as $key => $item) {
                $materials[$item->material_id] = ($materials[$item->material_id] ?? 0) + $item->quantity * $productsQuantity[$item->product_id];
            }

            foreach ($materials as $id => $quantity) {
                Inventory::create([
                    'material_id' => $id,
                    'production_id' => $production->id,
                    'quantity' => $quantity * -1,
                    'date_entry' => now(),
                    'notes' => 'Used for production #' . $production->token
                ]);
            }

            $orders = Order::with('products')->whereIn('id', array_unique($orderIds))->get();
            $orders = $orders->filter(function ($item) {
                return $item->isCompleted() === false && $item->status !== Order::STATUS_IN_PROGRESS;
            });

            Order::whereIn('id', $orders->pluck(null, 'id')->keys())->update(['status' => Order::STATUS_IN_PROGRESS]);

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

        $inventory = Inventory::where('production_id', $production->id)->with('material')->get();

        return view('production.show', [
            'production' => $production,
            'productionProducts' => $productionProducts,
            'orders' => $orders,
            'inventory' => $inventory
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
        $productData = $productData->get();

        $materials = Material::whereIn(
            'id',
            \DB::table('material_product')->whereIn('product_id', $productData->pluck('product_id'))
                ->pluck('material_id')
        )->get();

        return view('production.edit', [
            'production' => $production,
            'productionData' => $productionData->get(),
            'productData' => $productData,
            'materials' => $materials
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

            Inventory::where('production_id', $production->id)->get()->each(function ($item) {
                 $item->delete();
            });

            /** @var Collection $productionProducts */
            $productionProducts = $production->products;
            $productsQuantity = [];

            foreach ($productionProducts as $item) {
                $newQuantity = ($requestData['products'][$item->id]['quantity'] ?? 0) - $item->quantity;
                $productsQuantity[$item['product_id']] = $requestData['products'][$item->id]['quantity'] ?? 0;

                $orderProduct = OrderProduct::where([
                    'order_id' => $item->order_id,
                    'product_id' => $item->product_id
                ])->first();

                $orderProduct->remaining_quantity -= $newQuantity;
                $orderProduct->save();

                if ($orderProduct->remaining_quantity !== 0 && $orderProduct->order->status === Order::STATUS_DONE) {
                    $orderProduct->order->update(['status' => Order::STATUS_IN_PROGRESS]);
                }
            }

            $materialProduct = DB::table('material_product')
                ->whereIn('product_id', array_column($requestData['products'], 'product_id'))
                ->get();

            $materials = [];
            foreach ($materialProduct as $key => $item) {
                $materials[$item->material_id] = ($materials[$item->material_id] ?? 0) + $item->quantity * $productsQuantity[$item->product_id];
            }

            foreach ($materials as $id => $quantity) {
                Inventory::create([
                    'material_id' => $id,
                    'production_id' => $production->id,
                    'quantity' => $quantity * -1,
                    'date_entry' => now(),
                    'notes' => 'Used for production #' . $production->token
                ]);
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
