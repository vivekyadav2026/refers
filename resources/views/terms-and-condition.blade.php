@extends('layouts.app')
@section('title', 'Terms & Conditions — SK Solutions')

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
        <h1>Terms & Conditions</h1>
        <p>Last Updated: June 2026</p>
    </div>

    <div class="policy-content">
        <p>Welcome to <strong>SK Solutions and service</strong>. By using our website, services, and solutions, you agree to comply with and be bound by the following terms and conditions. Please read them carefully.</p>

        <h2>Services</h2>
        <p>We provide digital marketing services such as SEO, Social Media Marketing, Paid Ads (Google, Facebook, Instagram, etc.), Content Marketing, Web Design & Development, and related solutions.</p>
        <p>Service scope, deliverables, and timelines will be defined in the pricing plans shared with the client before starting the project.</p>

        <h2>Payments & Billing</h2>
        <p>All fees must be paid in advance as per the agreed quotation or proposal.</p>
        <p>For monthly/retainer services, payments are due before the start of each billing cycle.</p>
        <p>Any ad spend for Google, Facebook, or other platforms must be paid directly by the client or reimbursed separately.</p>

        <h2>Client Responsibilities</h2>
        <p>The client must provide accurate information, access to accounts (Google Ads, Facebook Business Manager, Website, etc.), and other required materials to execute the campaigns effectively.</p>
        <p>Delays caused by lack of required inputs from the client may affect project timelines, for which the agency will not be held responsible.</p>

        <h2>Confidentiality</h2>
        <p>Both parties agree to keep all sensitive business, marketing, and financial information confidential.</p>
        <p>We may showcase the client’s brand/logo/project in our portfolio unless otherwise agreed in writing.</p>

        <h2>Intellectual Property</h2>
        <p>All creative materials (graphics, content, campaigns, websites, etc.) developed during the project will remain the property of SK Solutions and services until full payment is received.</p>
        <p>After payment, ownership of final deliverables (except third-party licenses/software) will transfer to the client.</p>

        <h2>Limitation of Liability</h2>
        <p>We do not guarantee specific rankings, sales, or revenue as digital marketing results depend on multiple external factors (competition, budget, market conditions, platform policies, etc.).</p>
        <p>The agency will not be liable for any loss of profits, data, or business due to delays, third-party platform issues, or unforeseen circumstances.</p>

        <h2>Cancellation & Refund</h2>
        <p>Cancellation and refund requests are governed by our Cancellation & Refund Policy.</p>
        <p>Once services are initiated, payments are generally non-refundable.</p>

        <h2>Termination of Services</h2>
        <p>Either party may terminate services with a written notice of 7 days (unless otherwise mentioned in the agreement).</p>
        <p>The agency reserves the right to suspend/terminate services for non-payment, breach of agreement, or misuse of services.</p>

        <h2>Governing Law</h2>
        <p>These Terms & Conditions shall be governed by and interpreted under the laws of Delhi India.</p>
        <p>Any disputes shall be subject to the jurisdiction of courts located in Delhi India.</p>

        <div class="policy-contact">
            <h2>Contact Us</h2>
            <p>For any queries related to these terms, please contact us at:</p>
            <p>📩 <strong>Email:</strong> <a href="mailto:support@sksolutioss.com" style="color:#7c3aed; text-decoration:none;">support@sksolutioss.com</a></p>
            <p>📞 <strong>Phone:</strong> <a href="tel:+918287121769" style="color:#7c3aed; text-decoration:none;">+91 8287121769</a></p>
        </div>
    </div>
</div>
@endsection
