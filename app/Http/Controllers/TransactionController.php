<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\History;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::orderByDesc('created_at')->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $rules =
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $rules = [
            'payment_status' => 'nullable|in:paid,pending',
            'payment_method' => 'nullable|in:cash,credit_card,debit_card,mobile',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $transaction->payment_status = $request->payment_status;
        $transaction->payment_method = $request->payment_method;
        $transaction->save();
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'update',
            'table_name' => 'products',
            'record_id' => $transaction->id,
            'description' => 'Transaction ID '.$transaction->id.' updated',
        ]);
        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $order = Order::find($transaction->order_id);
        foreach ($order->orderDetails as $detail) {
            $detail->delete();
        }
        $order->delete();
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction and associated order details deleted successfully.');
    }
}
