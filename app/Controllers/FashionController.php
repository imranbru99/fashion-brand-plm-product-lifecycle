<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FashionProduct;
use Illuminate\Support\Facades\Validator;

class FashionController extends Controller
{
    public function index()
    {
        $fashionProducts = FashionProduct::all();
        return view('fashion.index', ['fashionProducts' => $fashionProducts]);
    }

    public function create()
    {
        return view('fashion.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fashionProduct = FashionProduct::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('fashion.show', ['id' => $fashionProduct->id]);
    }

    public function show($id)
    {
        $fashionProduct = FashionProduct::findOrFail($id);
        return view('fashion.show', ['fashionProduct' => $fashionProduct]);
    }

    public function edit($id)
    {
        $fashionProduct = FashionProduct::findOrFail($id);
        return view('fashion.edit', ['fashionProduct' => $fashionProduct]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fashionProduct = FashionProduct::findOrFail($id);
        $fashionProduct->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('fashion.show', ['id' => $fashionProduct->id]);
    }

    public function destroy($id)
    {
        $fashionProduct = FashionProduct::findOrFail($id);
        $fashionProduct->delete();

        return redirect()->route('fashion.index');
    }
}
