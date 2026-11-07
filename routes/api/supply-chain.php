<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplyChain;
use App\Http\Resources\SupplyChainResource;
use App\Http\Resources\SupplyChainCollection;

class SupplyChainController extends Controller
{
    public function index()
    {
        return new SupplyChainCollection(SupplyChain::all());
    }

    public function show($id)
    {
        $supplyChain = SupplyChain::findOrFail($id);
        return new SupplyChainResource($supplyChain);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:fashion_products,id',
            'quantity' => 'required|integer',
            'status' => 'nullable|string',
        ]);

        $supplyChain = SupplyChain::create($validatedData);
        return new SupplyChainResource($supplyChain);
    }

    public function update(Request $request, $id)
    {
        $supplyChain = SupplyChain::findOrFail($id);

        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:fashion_products,id',
            'quantity' => 'required|integer',
            'status' => 'nullable|string',
        ]);

        $supplyChain->update($validatedData);
        return new SupplyChainResource($supplyChain);
    }

    public function destroy($id)
    {
        $supplyChain = SupplyChain::findOrFail($id);
        $supplyChain->delete();
        return response()->noContent();
    }
}
