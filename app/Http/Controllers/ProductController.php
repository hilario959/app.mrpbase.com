<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $product = Product::all();
        return view('products.index', compact('product'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $materials = Material::get();
        return view('products.create', compact('materials'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'name'=>'required',
            'code'=>'required',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'materials' => 'nullable|array',
            'materials.*.id' => 'required|exists:App\Material',
            'materials.*.quantity' => 'required|numeric',
        ]);

        $product = Product::create(Arr::except($requestData, ['materials']));

        if (!empty($requestData['materials'])) {
            $materialsData = [];
            foreach ($requestData['materials'] as $item) {
                $materialsData[$item['id']] = ['quantity' => $item['quantity']];
            }
            $product->materials()->attach($materialsData);
        }

        return redirect()->route('product.index')->with('success', 'Product saved!');
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
     * @param Product $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $product->load('materials');

        $materials = Material::get();
        return view('products.edit', compact('product', 'materials'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $requestData = $request->validate([
            'name'=>'required',
            'code'=>'required',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'materials' => 'nullable|array',
            'materials.*.id' => 'required|exists:App\Material',
            'materials.*.quantity' => 'required|numeric',
        ]);

        $product->update(Arr::except($requestData, ['materials']));

        $product->materials()->detach();
        if (!empty($requestData['materials'])) {
            $materialsData = [];
            foreach ($requestData['materials'] as $item) {
                $materialsData[$item['id']] = ['quantity' => $item['quantity']];
            }
            $product->materials()->attach($materialsData);
        }

        return redirect()->route('product.index')->with('success', 'Product updated!');
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted!');
    }
}
