<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Material;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory = Inventory::all();
        $material = Material::latest()->get();
        return view('inventory.index', compact('inventory', 'material'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $material = Material::latest()->get();
        return view('inventory.create', compact('material'));
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
            'material_id'=>'required',
            'date_entry'=>'required',
            'quantity'=>'required'
        ]);
        $inventory = new Inventory([
            'material_id' => $request->get('material_id'),
            'date_entry' => $request->get('date_entry'),
            'quantity' => $request->get('quantity'),
            'notes' => $request->get('notes'),
        ]);
        $inventory->save();
        return redirect('/home/inventory')->with('success', 'Inventory saved!');

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
        $material = Material::latest()->get();
        $inventory = Inventory::find($id);
        return view('inventory.edit', compact('inventory','material'));
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
            'material_id'=>'required',
            'date_entry'=>'required',
            'quantity'=>'required'
        ]);
        $inventory = Inventory::find($id);
        $inventory->material_id =  $request->get('material_id');
        $inventory->date_entry = $request->get('date_entry');
        $inventory->quantity = $request->get('quantity');
        $inventory->notes = $request->get('notes');
        $inventory->save();
        return redirect('/home/inventory')->with('success', 'Inventory updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();
        return redirect('/home/inventory')->with('success', 'Inventory deleted!');
    }
}
