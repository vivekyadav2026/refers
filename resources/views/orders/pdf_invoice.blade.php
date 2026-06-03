<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #1e293b; line-height: 1.6; font-size: 13px; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; padding: 20px; }
        
        /* Typography */
        h1, h2, h3, h4, p { margin: 0; padding: 0; }
        h1 { font-size: 28px; color: #0f172a; font-weight: bold; }
        h2 { font-size: 22px; color: #334155; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 5px; }
        .text-slate-500 { color: #64748b; }
        .text-slate-700 { color: #334155; }
        .text-indigo { color: #4f46e5; }
        .font-bold { font-weight: bold; }
        
        /* Layout Tables */
        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        
        /* Header */
        .header-table { margin-bottom: 30px; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; }
        .header-table td { vertical-align: top; }
        
        /* Billing & Order Info */
        .info-table { margin-bottom: 30px; }
        .info-table td { vertical-align: top; width: 50%; }
        
        /* Items Table */
        .items-table { margin-bottom: 30px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        .items-table th { background-color: #f8fafc; color: #475569; font-size: 12px; text-transform: uppercase; padding: 12px 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .items-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        .items-table th.right, .items-table td.right { text-align: right; }
        
        /* Summary Table */
        .summary-wrapper { width: 100%; }
        .summary-table { width: 45%; float: right; border-collapse: collapse; }
        .summary-table td { padding: 8px 0; font-size: 13px; }
        .summary-table td.label { color: #64748b; text-align: right; padding-right: 20px; }
        .summary-table td.value { text-align: right; font-weight: bold; color: #1e293b; width: 110px;}
        .summary-table tr.total-row td { border-top: 2px solid #e2e8f0; padding-top: 15px; font-size: 18px; color: #4f46e5; font-weight: bold; }
        .summary-table tr.discount-row td { color: #16a34a; }
        
        /* Footer */
        .footer { clear: both; margin-top: 50px; padding-top: 20px; border-top: 1px solid #e2e8f0; text-align: center; font-size: 11px; color: #94a3b8; }
        
        .badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .badge-paid { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-processing { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
        
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="width: 60%;">
                    @if(file_exists(public_path('logo.jpg')))
                        <img src="{{ public_path('logo.jpg') }}" alt="SK Solutions Logo" style="max-height: 55px; margin-bottom: 15px;">
                    @else
                        <h1 class="text-indigo" style="margin-bottom: 10px;">SK Solutions</h1>
                    @endif
                    <p class="text-slate-500">
                        123 Tech Lane, IT Park<br>
                        New Delhi, 110001, India<br>
                        support@sksolutions.com<br>
                        +91 98765 43210
                    </p>
                </td>
                <td style="width: 40%; text-align: right;">
                    <h2 class="text-indigo">INVOICE</h2>
                    <p class="text-slate-500 font-bold" style="font-size: 16px; margin-bottom: 15px; color: #0f172a;">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                    
                    <p style="margin-bottom: 8px;">
                        <span class="text-slate-500">Date:</span> 
                        <strong class="text-slate-700">{{ $order->created_at->format('d M, Y') }}</strong>
                    </p>
                    <p>
                        @php
                            $badgeClass = 'badge-pending';
                            if (in_array($order->status, ['paid', 'completed'])) $badgeClass = 'badge-paid';
                            elseif (in_array($order->status, ['in_progress', 'processing'])) $badgeClass = 'badge-processing';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ str_replace('_', ' ', $order->status) }}</span>
                    </p>
                </td>
            </tr>
        </table>

        <!-- Billing Info -->
        <table class="info-table">
            <tr>
                <td style="padding-right: 20px;">
                    <h4 style="color: #64748b; font-size: 12px; text-transform: uppercase; margin-bottom: 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">Billed To</h4>
                    <p style="font-size: 14px; font-weight: bold; margin-bottom: 5px; color: #0f172a;">
                        {{ $order->customer_name ?? ($order->user->name ?? 'Guest Customer') }}
                    </p>
                    
                    @if($order->company_name || ($order->lead && $order->lead->company_name))
                        <p class="text-slate-700" style="margin-bottom: 3px;">
                            <strong class="text-slate-500">Company:</strong> {{ $order->company_name ?? $order->lead->company_name }}
                        </p>
                    @endif
                    
                    @if($order->customer_email ?? $order->user->email)
                        <p class="text-slate-700" style="margin-bottom: 3px;">
                            {{ $order->customer_email ?? $order->user->email }}
                        </p>
                    @endif
                    
                    @if($order->customer_phone ?? $order->user->phone)
                        <p class="text-slate-700">
                            {{ $order->customer_phone ?? $order->user->phone }}
                        </p>
                    @endif
                </td>
                <td style="padding-left: 20px;">
                    @if($order->businessDetail)
                        <h4 style="color: #64748b; font-size: 12px; text-transform: uppercase; margin-bottom: 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">Business Details</h4>
                        <p style="font-size: 13px; font-weight: bold; margin-bottom: 4px; color: #0f172a;">
                            {{ $order->businessDetail->business_name }}
                        </p>
                        @if($order->businessDetail->domain_name)
                            <p class="text-slate-700" style="margin-bottom: 4px;">{{ $order->businessDetail->domain_name }}</p>
                        @endif
                        @if($order->businessDetail->office_address)
                            <p class="text-slate-500" style="font-size: 12px; line-height: 1.4;">{{ $order->businessDetail->office_address }}</p>
                        @endif
                    @endif
                </td>
            </tr>
        </table>

        <!-- Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 60%;">Description</th>
                    <th class="right" style="width: 35%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $planPrice = $order->items->first()->subtotal ?? ($order->amount - $order->platform_price - $order->domain_charge - $order->gst_amount + $order->coupon_discount);
                @endphp
                <tr>
                    <td>1</td>
                    <td>
                        <strong style="color: #0f172a; display: block; margin-bottom: 4px;">{{ $order->service->name ?? $order->lead->service_needed ?? 'Custom Service' }}</strong>
                        <span class="text-slate-500" style="font-size: 11px;">Primary Service Plan</span>
                    </td>
                    <td class="right">
                        <strong style="color: #0f172a;">&#8377;{{ number_format($planPrice, 2) }}</strong>
                    </td>
                </tr>
                
                @php $counter = 2; @endphp

                @if($order->platform_choice && $order->platform_price > 0)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>
                        <strong style="color: #334155; display: block; margin-bottom: 4px;">Platform Setup ({{ ucfirst($order->platform_choice) }})</strong>
                        <span class="text-slate-500" style="font-size: 11px;">Additional platform infrastructure fee</span>
                    </td>
                    <td class="right">
                        <strong style="color: #334155;">&#8377;{{ number_format($order->platform_price, 2) }}</strong>
                    </td>
                </tr>
                @endif

                @if($order->domain_choice && $order->domain_choice !== 'already_have' && $order->domain_charge > 0)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>
                        <strong style="color: #334155; display: block; margin-bottom: 4px;">Domain Registration (.{{ $order->domain_choice }})</strong>
                        <span class="text-slate-500" style="font-size: 11px;">Annual domain registration fee</span>
                    </td>
                    <td class="right">
                        <strong style="color: #334155;">&#8377;{{ number_format($order->domain_charge, 2) }}</strong>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary-wrapper">
            <table class="summary-table">
                <tr>
                    <td class="label">Subtotal:</td>
                    <td class="value">&#8377;{{ number_format($order->amount - $order->gst_amount + $order->coupon_discount, 2) }}</td>
                </tr>
                
                @if($order->gst_amount > 0)
                <tr>
                    <td class="label">GST (18%):</td>
                    <td class="value">&#8377;{{ number_format($order->gst_amount, 2) }}</td>
                </tr>
                @endif

                @if($order->coupon_discount > 0)
                <tr class="discount-row">
                    <td class="label">Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}:</td>
                    <td class="value">-&#8377;{{ number_format($order->coupon_discount, 2) }}</td>
                </tr>
                @endif

                <tr class="total-row">
                    <td class="label" style="color: #0f172a;">Total Amount:</td>
                    <td class="value">&#8377;{{ number_format($order->amount, 2) }}</td>
                </tr>
            </table>
        </div>
        <div style="clear: both;"></div>

        <!-- Footer -->
        <div class="footer">
            <p style="font-weight: bold; color: #475569; margin-bottom: 5px; font-size: 13px;">Thank you for your business!</p>
            <p>If you have any questions regarding this invoice, please contact our support team at support@sksolutions.com</p>
            <p style="margin-top: 15px; font-style: italic;">This is a computer-generated document and requires no signature.</p>
        </div>
    </div>
</body>
</html>
