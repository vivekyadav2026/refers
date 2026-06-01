<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SKSolutions Partner ID Card</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
            margin: 0;
            padding: 0;
        }
        .card {
            width: 350px;
            height: 550px;
            border: 2px solid #4f46e5;
            border-radius: 15px;
            margin: 20px auto;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
        }
        .header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            opacity: 0.9;
        }
        .photo-container {
            text-align: center;
            margin-top: 30px;
        }
        .photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #4f46e5;
            object-fit: cover;
        }
        .details {
            padding: 20px;
            text-align: center;
        }
        .name {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .role {
            font-size: 14px;
            color: #64748b;
            margin: 0 0 20px 0;
            font-weight: bold;
        }
        .info-row {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .label {
            color: #64748b;
            font-weight: bold;
        }
        .value {
            color: #0f172a;
            font-weight: bold;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 15px 0;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
        }
        .validity {
            position: absolute;
            top: 20px;
            right: -30px;
            background-color: #fbbf24;
            color: #b45309;
            font-size: 10px;
            font-weight: bold;
            padding: 5px 30px;
            transform: rotate(45deg);
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="validity">VERIFIED</div>
        
        <div class="header">
            <h1>SKSolutions Partner</h1>
            <p>Official Sales Representative</p>
        </div>

        <div class="photo-container">
            @php
                $path = public_path('storage/' . $kyc->photo_path);
                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                } else {
                    $base64 = ''; // Fallback if image is missing
                }
            @endphp
            <!-- Embedded directly as base64 to ensure DOMPDF compatibility across all environments -->
            <img src="{{ $base64 }}" alt="Partner Photo" class="photo">
        </div>

        <div class="details">
            <h2 class="name">{{ $user->name }}</h2>
            <p class="role">Sales Partner</p>

            <div class="info-row">
                <span class="label">Partner ID:</span>
                <span class="value">SK-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Phone:</span>
                <span class="value">{{ $user->phone ?? 'N/A' }}</span>
            </div>

            <div class="info-row">
                <span class="label">Issued:</span>
                <span class="value">{{ $kyc->updated_at->format('M d, Y') }}</span>
            </div>
        </div>

        <div class="footer">
            This card is the property of SKSolutions Networks.<br>
            If found, please return to support@sksolutioss.com
        </div>
    </div>

</body>
</html>
