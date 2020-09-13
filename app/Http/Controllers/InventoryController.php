<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Material;

class InventoryController extends Controller
{
    /**
     * @param Material $material
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Material $material, Request $request)
    {
        $requestData = $request->validate([
            'date_entry'=> 'required',
            'quantity'=> 'required',
            'notes' => 'nullable|string'
        ]);

        $material->inventory()->create($requestData);

        return redirect()->route('material.edit', [$material->id])
            ->with('success', 'Inventory saved!');
    }
}
