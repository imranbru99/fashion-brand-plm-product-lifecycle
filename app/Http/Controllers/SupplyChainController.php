<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplyChain;
use Illuminate\Support\Facades\Validator;

class SupplyChainController extends Controller
{
    public function index()
    {
        $supplyChains = SupplyChain::all();
        return view('admin.supply-chains.index', compact('supplyChains'));
    }

    public function create()
    {
        return view('admin.supply-chains.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier' => 'required|string',
            'product' => 'required|string',
            'quantity' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supplyChain = SupplyChain::create([
            'supplier' => $request->input('supplier'),
            'product' => $request->input('product'),
            'quantity' => $request->input('quantity'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.supply-chains.index')->with('success', 'Supply chain created successfully.');
    }

    public function edit($id)
    {
        $supplyChain = SupplyChain::findOrFail($id);
        return view('admin.supply-chains.edit', compact('supplyChain'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'supplier' => 'required|string',
            'product' => 'required|string',
            'quantity' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supplyChain = SupplyChain::findOrFail($id);
        $supplyChain->update([
            'supplier' => $request->input('supplier'),
            'product' => $request->input('product'),
            'quantity' => $request->input('quantity'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.supply-chains.index')->with('success', 'Supply chain updated successfully.');
    }

    public function destroy($id)
    {
        $supplyChain = SupplyChain::findOrFail($id);
        $supplyChain->delete();

        return redirect()->route('admin.supply-chains.index')->with('success', 'Supply chain deleted successfully.');
    }
}
