<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header h1 {
            font-size: 18px;
        }
        .table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="receipt-header">
        <h1>Struk Pembelian</h1>
        <p>Order ID: {{ $order->id }}</p>
        <p>Customer: {{ $order->customer->name }}</p>
        <p>Date: {{ $order->created_at->format('d M Y, H:i') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp{{ number_format($detail->product->price, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($detail->product->price * $detail->quantity, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4" style="font-weight: bold; text-align: right;">Total:</td>
                    <td>Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="footer">
        <p>Thank you for your purchase!</p>
    </div>

</body>
</html>
