<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Partner Agreement - SK Solutions</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
            margin: 40px;
            color: #333;
            line-height: 1.6;
        }
        h1 {
            text-align: center;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
        }
        .date {
            text-align: right;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .parties {
            margin-bottom: 30px;
        }
        .parties h3 {
            margin-bottom: 5px;
        }
        .content {
            text-align: justify;
        }
        .signature-section {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            width: 45%;
            display: inline-block;
            vertical-align: top;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 80%;
            margin-top: 50px;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Independent Partner Agreement</h1>
    <div class="date">
        Date: {{ now()->format('F j, Y') }}
    </div>

    <div class="parties">
        <p>This Independent Partner Agreement (the "Agreement") is entered into by and between:</p>
        <h3>SK Solutions</h3>
        <p>Uttam Nagar, Delhi, India (hereinafter referred to as the "Company")</p>
        <p><strong>AND</strong></p>
        <h3>{{ $user->name }}</h3>
        <p>Email: {{ $user->email }}<br>Phone: {{ $user->phone }}<br>(hereinafter referred to as the "Partner")</p>
    </div>

    <div class="content">
        <h3>1. Engagement</h3>
        <p>The Company hereby engages the Partner to refer clients for the digital services provided by the Company. The Partner accepts this engagement and agrees to perform the referral services on an independent contractor basis.</p>

        <h3>2. Commissions</h3>
        <p>For every successful referral resulting in a completed sale of services, the Partner will earn a commission as defined in the Company's current commission structure. Commissions will be tracked in the Partner's Wallet and are subject to the Company's withdrawal policies.</p>

        <h3>3. Relationship of Parties</h3>
        <p>The Partner is an independent contractor. Nothing in this Agreement shall be construed to create an employer-employee relationship, partnership, or joint venture between the parties.</p>

        <h3>4. Confidentiality</h3>
        <p>The Partner agrees to keep confidential all proprietary information, pricing structures, and client details provided by the Company or obtained during the course of this engagement.</p>
        
        <h3>5. Term & Termination</h3>
        <p>This Agreement is effective upon the Partner's acceptance (via online registration) and shall continue until terminated by either party with a 14-day written notice. The Company reserves the right to terminate immediately for violation of terms or fraudulent activity.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p><strong>For SK Solutions:</strong></p>
            <div class="signature-line">Authorized Signatory</div>
        </div>
        <div class="signature-box">
            <p><strong>For the Partner:</strong></p>
            <div class="signature-line">{{ $user->name }} (Digitally Accepted)</div>
        </div>
    </div>
</body>
</html>
