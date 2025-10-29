<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\History;
use Barryvdh\DomPDF;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
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
        return view('transactions.show', compact('transaction'));
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
        $latestOrder = Order::where('table_id', $transaction->order->table_id)->latest()->first();
        if ($transaction->order->id !== $latestOrder->id) {
            return redirect()->back()->with('error', 'Transaction does not belong to the latest order for this table.');
        }

        $transaction->payment_status = $request->payment_status;
        $transaction->payment_method = $request->payment_method;
        $transaction->save();
        if( $request->payment_status == 'paid' ){
            $order = Order::find($transaction->order_id);
            $order->status = 'completed';
            $order->save();
        }
        History::create([
            'user_id' => Auth::user()->id,
            'action' => 'update',
            'table_name' => 'products',
            'record_id' => $transaction->id,
            'description' => 'Transaction ID '.$transaction->id.' updated',
        ]);
        return redirect()->route('tables.show', $transaction->order->table->id)->with('success', 'Transaction updated successfully.');
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
        return redirect()->route('tables.index')->with('success', 'Transaction and associated order details deleted successfully.');
    }
    public function generateReceipt($id)
    {
        $transaction = Transaction::findOrFail($id);
        $total = $transaction->order->orderDetails->sum(function ($detail) {
            return $detail->product->price * $detail->quantity;
        });
        $order = $transaction->order;
        $pdf = Pdf::loadView('pdf.receipt', compact('transaction','order', 'total'));

        return $pdf->download('struk_pembelian_' . $transaction->id . '.pdf');
    }
}
