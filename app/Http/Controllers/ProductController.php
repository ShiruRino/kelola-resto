<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('name')->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $product = Product::create($request->all());
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'create',
            'table_name' => 'products',
            'record_id' => $product->id,
            'description' => 'Product '.$product->name.' created',
        ]);
        return redirect()->route('products.index')->with('success', 'Product '.$product->name);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $product->update($request->all());
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'update',
            'table_name' => 'products',
            'record_id' => $product->id,
            'description' => 'Product '.$product->name.' updated',
        ]);
        return redirect()->route('products.index')->with('success', 'Product '.$product->name.' updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'delete',
            'table_name' => 'products',
            'record_id' => $product->id,
            'description' => 'Product '.$product->name.' deleted',
        ]);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product '.$product->name.' deleted');
    }
}
