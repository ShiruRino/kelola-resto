<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Auth;
use App\Models\Order;
use App\Models\History;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('status', '!=', 'completed')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'table_number' => 'required',
            'customer_phone' => 'required|exists:customers,phone',
            'product' => 'required|array|min:1',
            'product.*' => 'exists:products,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'integer|min:1'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $customer = Customer::where('phone', $request->customer_phone)->first();
        $order = Order::create([
            'table_number' => $request->table_number,
            'customer_id' => $customer->id,
            'status' => 'new',
            'user_id' => Auth::id(),
        ]);

        foreach ($request->product as $index => $productId) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $request->quantity[$index],
            ]);
        }
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'create',
            'table_name' => 'orders',
            'record_id' => Order::latest()->first()->id,
            'description' => 'Order created by user '.Auth::user()->username,
        ]);
        return redirect()->route('orders.index')->with('success', 'Order created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'status' => 'required|in:new,process,ready,completed,cancelled',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'update',
            'table_name' => 'orders',
            'record_id' => $order->id,
            'description' => 'Order ID '.$order->id.' status updated to '.$request->status.' by user '.Auth::user()->username,
        ]);
        return redirect()->route('orders.index')->with('success', 'Order ID '.$order->id.' status updated to '.$request->status);
    }
    public function complete(Request $request, $id){
        $order = Order::findOrFail($id);
        $order->status = 'completed';
        Transaction::create([
            'order_id' => $order->id,
            'total' => $order->orderDetails->sum(function ($detail) {
                return $detail->product->price * $detail->quantity;
            }),
            'payment_status' => 'pending',
            'payment_method' => null,
        ]);
        $order->save();
        return redirect()->route('orders.index')->with('success', 'Order ID ' . $order->id . ' was completed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'delete',
            'table_name' => 'orders',
            'record_id' => $order->id,
            'description' => 'Order ID '.$order->id.' deleted by user '.Auth::user()->username,
        ]);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order ID '.$order->id.' deleted');
    }
}
