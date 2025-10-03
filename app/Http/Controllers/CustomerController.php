<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('name')->paginate();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'gender' => 'required|boolean',
            'phone' => 'required|unique:customers,phone',
            'address' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $customer = Customer::create($request->all());
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'create',
            'table_name' => 'customers',
            'record_id' => $customer->id,
            'description' => 'Customer '.$customer->name.' created',
        ]);
        return redirect()->route('customers.index')->with('success', 'Customer '.$request->name.' created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $rules = [
            'name' => 'required',
            'gender' => 'required|boolean',
            'phone' => 'required|unique:customers,phone,',
            'address' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $customer->update($request->all());
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'update',
            'table_name' => 'customers',
            'record_id' => $customer->id,
            'description' => 'Customer '.$customer->name.' updated',
        ]);
        return redirect()->route('customers.index')->with('success', 'Customer '.$customer->name.' updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'delete',
            'table_name' => 'customers',
            'record_id' => $customer->id,
            'description' => 'Customer '.$customer->name.' deleted',
        ]);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer '.$customer->name.' deleted');
    }
}
