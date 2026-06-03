<!DOCTYPE html>
<html>
<head>
    <title>Your Invoice</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <h2>Thank you for your order!</h2>
    </div>

    <p>Dear {{ $order->user->name ?? $order->customer_name ?? 'Customer' }},</p>

    <p>Your payment for <strong>{{ optional($order->service)->name ?? 'Service' }}</strong> has been successfully processed.</p>
    
    <p>Please find attached the invoice for your order (<strong>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>) for your records.</p>
    
    <div style="background-color: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <p style="margin: 0;"><strong>Order ID:</strong> #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p style="margin: 5px 0 0 0;"><strong>Amount Paid:</strong> ₹{{ number_format($order->amount, 2) }}</p>
        <p style="margin: 5px 0 0 0;"><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
    </div>

    <p>If you have any questions or concerns, feel free to reply to this email or contact our support team.</p>

    <br>
    <p>Best Regards,</p>
    <p><strong>SK Solutions Team</strong></p>

</body>
</html>
