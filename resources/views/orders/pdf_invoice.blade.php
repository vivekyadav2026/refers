<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.5; font-size: 14px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #4f46e5; font-size: 36px; }
        .info { width: 100%; display: table; }
        .info-row { display: table-row; }
        .info-cell { display: table-cell; padding: 5px; }
        .billing-info { margin-top: 30px; margin-bottom: 40px; display: table; width: 100%; }
        .table-items { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .table-items th { background: #f8fafc; text-align: left; padding: 12px; border-bottom: 2px solid #e2e8f0; }
        .table-items td { padding: 12px; border-bottom: 1px solid #e2e8f0; }
        .total-row td { font-weight: bold; font-size: 18px; }
        .footer { margin-top: 50px; text-align: center; color: #64748b; font-size: 12px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <table style="width:100%">
                <tr>
                    <td style="text-align: left;">
                        <h1>SK Solutions</h1>
                        <p>123 Tech Lane, IT Park<br>Delhi, India<br>support@sksolutions.com</p>
                    </td>
                    <td style="text-align: right;">
                        <h2 style="margin:0; color:#333;">INVOICE</h2>
                        <p>
                            <strong>Order #:</strong> ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}<br>
                            <strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}<br>
                            <strong>Status:</strong> <span style="text-transform: uppercase;">{{ $order->status }}</span>
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="billing-info">
            <table style="width:100%">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <h3 style="margin-top:0; color:#475569;">Billed To:</h3>
                        <strong>{{ $order->user->name ?? 'Guest' }}</strong><br>
                        {{ $order->user->email ?? '' }}<br>
                        {{ $order->user->phone ?? '' }}<br>
                        @if($order->lead && $order->lead->company_name)
                            Company: {{ $order->lead->company_name }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <table class="table-items">
            <thead>
                <tr>
                    <th>Item / Description</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $order->service->name }}</strong>
                        <p style="margin-top: 5px; color: #64748b; font-size: 12px;">Service Request Fulfillment</p>
                    </td>
                    <td style="text-align: right;">
                        ₹{{ number_format($order->amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; border-bottom: none;"><strong>Subtotal:</strong></td>
                    <td style="text-align: right; border-bottom: none;">₹{{ number_format($order->amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td style="text-align: right; border-bottom: none;">Total:</td>
                    <td style="text-align: right; border-bottom: none;">₹{{ number_format($order->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Thank you for doing business with SK Solutions!</p>
            <p>This is a computer-generated document and does not require a signature.</p>
        </div>
    </div>
</body>
</html>
