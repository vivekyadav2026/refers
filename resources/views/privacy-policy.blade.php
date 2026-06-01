@extends('layouts.app')
@section('title', 'Privacy Policy — SK Solutions')

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
        <h1>Privacy Policy</h1>
        <p>Effective Date: June 2026</p>
    </div>

    <div class="policy-content">
        <h2>Introduction</h2>
        <p>At SK Solutions and services we respect your privacy and are committed to protecting your personal data. This Privacy Policy explains how we collect, use, and safeguard your information when you visit or make a purchase from our website. By using our services, you agree to the practices described in this Privacy Policy.</p>

        <h2>Information We Collect</h2>
        <p>We may collect the following types of information:</p>
        <ul>
            <li><strong>Personal Information:</strong> Name, email address, phone number, billing address, and other contact information.</li>
            <li><strong>Payment Information:</strong> Transaction details. (We do not store your complete credit/debit card numbers or sensitive payment data.)</li>
            <li><strong>Usage Data:</strong> IP address, device type, browser information, pages visited, time spent on our platform, and other analytical data.</li>
            <li><strong>Cookies and Tracking Technologies:</strong> Used to enhance your browsing experience and improve our service.</li>
        </ul>

        <h2>How We Use Your Information</h2>
        <p>We use your information to:</p>
        <ul>
            <li>Create and manage your account.</li>
            <li>Process and fulfill orders.</li>
            <li>Communicate with you regarding orders, services, and promotions.</li>
            <li>Provide customer support.</li>
            <li>Improve our website, services, and overall user experience.</li>
            <li>Send marketing emails if you have opted in (you can unsubscribe anytime).</li>
        </ul>

        <h2>How We Share Your Information</h2>
        <p>We may share your information with:</p>
        <ul>
            <li><strong>Service Providers:</strong> For hosting, payment processing, analytics, and support services.</li>
            <li><strong>Legal Authorities:</strong> If required by law, regulation, or court order.</li>
        </ul>
        <p>We do not sell, rent, or trade your personal information to third parties.</p>

        <h2>Payment Information and Third-Party Processors</h2>
        <p>Payments are securely handled through trusted third-party providers such as Stripe, Razorpay, PayPal, and others. We do not store your full card information. These providers manage your sensitive payment details directly under their secured systems.</p>

        <h2>Cookies and Tracking Technologies</h2>
        <p>We use cookies to:</p>
        <ul>
            <li>Keep you logged into your account.</li>
            <li>Save your shopping cart information.</li>
            <li>Understand how visitors use our site.</li>
            <li>Improve site speed and performance.</li>
        </ul>
        <p>You can control cookies through your browser settings, but disabling cookies may affect certain functionalities.</p>

        <h2>Data Retention</h2>
        <p>We retain your personal data as long as your account is active or as needed to provide you services. After account deletion, certain data may be stored for legal, tax, or security obligations.</p>

        <h2>Data Security</h2>
        <p>We implement strong security measures including:</p>
        <ul>
            <li>Secure SSL encryption.</li>
            <li>Regular server updates and firewall protections.</li>
            <li>Restricted access to your data internally.</li>
        </ul>
        <p>Despite our efforts, no method of transmission over the internet or method of electronic storage is 100% secure. We encourage you to also take steps to protect your information.</p>

        <h2>Your Data Rights</h2>
        <p>You have the right to:</p>
        <ul>
            <li>Access your personal data.</li>
            <li>Correct inaccuracies in your information.</li>
            <li>Request deletion of your personal data.</li>
            <li>Object to processing for marketing purposes.</li>
        </ul>
        <p>To exercise any of these rights, please email us at <a href="mailto:support@sksolutioss.com" style="color:#6366f1; text-decoration:none;">support@sksolutioss.com</a></p>

        <h2>Third-Party Services and Links</h2>
        <p>Our website may contain links to third-party websites. We are not responsible for the privacy practices of those websites. Please review their privacy policies separately.</p>

        <h2>Children’s Privacy</h2>
        <p>Our services are not intended for individuals under the age of 18. We do not knowingly collect information from minors. If you believe we have inadvertently collected such information, please contact us for immediate deletion.</p>

        <h2>International Users</h2>
        <p>If you are accessing our services from outside India, please note that your information may be transferred, stored, and processed in India. By using our service, you consent to such transfers.</p>

        <h2>Changes to This Privacy Policy</h2>
        <p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with a new effective date. We encourage you to review our Privacy Policy periodically.</p>

        <h2>Your Consent</h2>
        <p>By using our website and services, you consent to the terms of this Privacy Policy.</p>

        <div class="policy-contact">
            <h2>Contact Us</h2>
            <p>If you have any questions or concerns about this Privacy Policy, you can contact us:</p>
            <p>📩 <strong>Email:</strong> <a href="mailto:support@sksolutioss.com" style="color:#6366f1; text-decoration:none;">support@sksolutioss.com</a></p>
            <p>📞 <strong>Phone:</strong> <a href="tel:+918287121769" style="color:#6366f1; text-decoration:none;">+91 8287121769</a></p>
            <p style="font-size: 0.9rem; margin-top:15px; color:#64748b;">We aim to respond within 48 hours, though response times may vary based on the nature of the inquiry.</p>
        </div>
    </div>
</div>
@endsection
