@extends('layouts.app')
@section('title', 'Cancellation & Refund Policy — SK Solutions')

@section('content')

<style>
/* Typography & Spacing */
.policy-container {
    max-width: 800px;
    margin: 140px auto 40px;
    padding: 40px;
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.02);
    border: 1px solid #f1f5f9;
}
.policy-header {
    text-align: center;
    margin-bottom: 40px;
}
.policy-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 12px;
}
.policy-header p {
    color: #64748b;
    font-size: 1rem;
}
.policy-content h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1e293b;
    margin-top: 35px;
    margin-bottom: 15px;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 8px;
}
.policy-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #334155;
    margin-top: 25px;
    margin-bottom: 10px;
}
.policy-content p {
    font-size: 1rem;
    line-height: 1.8;
    color: #475569;
    margin-bottom: 18px;
}
.policy-content ul {
    list-style-type: disc;
    padding-left: 25px;
    margin-bottom: 18px;
}
.policy-content ul li {
    font-size: 1rem;
    color: #475569;
    margin-bottom: 10px;
    line-height: 1.7;
}
.policy-contact {
    background: #f8fafc;
    border-left: 4px solid #7c3aed;
    padding: 25px;
    margin-top: 40px;
    border-radius: 0 16px 16px 0;
    border: 1px solid #f1f5f9;
    border-left-width: 4px;
}
.policy-contact p {
    margin: 0 0 12px;
}

/* Responsiveness */
@media (max-width: 1024px) {
    .policy-container {
        margin-top: 120px;
    }
}

@media (max-width: 768px) {
    .policy-container {
        margin: 100px 16px 40px;
        padding: 24px;
        border-radius: 16px;
    }
    .policy-header {
        margin-bottom: 30px;
    }
    .policy-header h1 {
        font-size: 1.85rem;
    }
    .policy-content h2 {
        font-size: 1.35rem;
        margin-top: 25px;
    }
    .policy-content p, .policy-content ul li {
        font-size: 0.95rem;
        line-height: 1.7;
    }
    .policy-contact {
        padding: 20px;
        margin-top: 30px;
    }
}
</style>

<div class="policy-container">
    <div class="policy-header">
        <h1>Cancellation and Refund</h1>
        <p>Last Updated: June 2026</p>
    </div>

    <div class="policy-content">
        <p>At <strong>SK Solutions and services</strong>, we value our clients and aim to deliver the best digital marketing services. However, due to the nature of our work, we follow a clear cancellation and refund policy:</p>

        <h2>Cancellation Policy</h2>
        <ul>
            <li>Clients may request cancellation of services by providing a written notice via email to <a href="mailto:support@sksolutioss.com" style="color:#7c3aed; text-decoration:none;">support@sksolutioss.com</a>.</li>
            <li>Cancellation requests for ongoing monthly services (SEO, Social Media Marketing, Google Ads, etc.) must be made at least <strong>7 days</strong> before the next billing cycle.</li>
            <li>Once a campaign/project has been initiated and resources are allocated, cancellation will not be possible for that billing cycle.</li>
        </ul>

        <h2>Refund Policy</h2>
        <ul>
            <li><strong>Service Fees:</strong> Payments made for services (SEO, Google Ads, Facebook & Instagram Ads, & Ads Management, Web Design & Development, etc.) are non-refundable once work has started.</li>
            <li><strong>Prepaid Plans/Retainers:</strong> If you cancel before the work has started, you may be eligible for a partial refund after deducting administrative/consultation charges.</li>
            <li><strong>Digital Ads Spend:</strong> Any money spent on third-party platforms (Google, Facebook, Instagram, etc.) is non-refundable as it is directly paid to the platform.</li>
            <li><strong>Custom Projects (Web Design/Development):</strong> Refunds are not applicable once design/development work has commenced.</li>
        </ul>

        <h2>No Refunds for Third-Party Services</h2>
        <p>SK Solutions does not collect commissions or transaction fees on your website’s sales, and all revenue from your sales is subject to fees charged by your chosen payment gateways (e.g., Razorpay, PayU, Cashfree, Instamojo, PayPal, Stripe). Refunds for payments processed through third-party gateways or for third-party services (e.g., domain registrars, Shiprocket & shipping providers) are not handled by SK Solutions. You must contact the respective third-party provider for their refund policies.</p>

        <h2>Refund Exceptions</h2>
        <p>Refunds may be considered only in the following cases:</p>
        <ul>
            <li>Duplicate payment made by the client.</li>
            <li>Services not delivered as per the agreed scope (after proper review and verification).</li>
        </ul>

        <div class="policy-contact">
            <h2>Contact Us</h2>
            <p>For cancellation or refund-related queries, please contact us at:</p>
            <p>📩 <strong>Email:</strong> <a href="mailto:support@sksolutioss.com" style="color:#7c3aed; text-decoration:none;">support@sksolutioss.com</a></p>
            <p>📞 <strong>Phone:</strong> <a href="tel:+918287121769" style="color:#7c3aed; text-decoration:none;">+91 8287121769</a></p>
        </div>
    </div>
</div>
@endsection
