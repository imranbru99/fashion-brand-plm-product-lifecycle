<?php

namespace App\Http\Controllers;

use App\Models\ManufacturingDepartment;
use App\Models\ManufacturingProduct;
use Illuminate\Http\Request;

class ManufacturingController extends Controller
{
    public function index()
    {
        $departments = ManufacturingDepartment::all();
        $products = ManufacturingProduct::all();
        return view('manufacturing.index', compact('departments', 'products'));
    }

    public function create()
    {
        return view('manufacturing.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $department = ManufacturingDepartment::create($validatedData);
        $product = ManufacturingProduct::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'status' => $request->input('status'),
            'department_id' => $department->id,
        ]);

        return redirect()->route('manufacturing.index')->with('success', 'Manufacturing product created successfully.');
    }

    public function edit(ManufacturingProduct $product)
    {
        return view('manufacturing.edit', compact('product'));
    }

    public function update(Request $request, ManufacturingProduct $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $product->update($validatedData);

        return redirect()->route('manufacturing.index')->with('success', 'Manufacturing product updated successfully.');
    }

    public function destroy(ManufacturingProduct $product)
    {
        $product->delete();

        return redirect()->route('manufacturing.index')->with('success', 'Manufacturing product deleted successfully.');
    }
}
