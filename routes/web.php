<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\Admin\AdminLeadController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminKycController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KycController;
use App\Models\Service;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::redirect('/register', '/login')->name('register');

// Partner: Phone OTP login
Route::post('/login/send-otp', [AuthController::class, 'sendOtp'])->name('login.send_otp');
Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify.show');
Route::post('/verify', [AuthController::class, 'verifyOtp'])->name('verify.check');

// Admin: Email + Password login
Route::post('/admin-login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PUBLIC SERVICE ROUTES
Route::get('/services', function () {
    $servicesByCategory = Service::all()->groupBy('category');
    return view('services.index', ['servicesByCategory' => $servicesByCategory]);
})->name('services.index');

Route::get('/services/{slug}', function ($slug) {
    $service = Service::where('slug', $slug)->firstOrFail();
    return view('services.show', ['service' => $service]);
})->name('services.show');

// PARTNER ROUTES
Route::middleware(['auth'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/leads', [\App\Http\Controllers\LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/create', [\App\Http\Controllers\LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads', [\App\Http\Controllers\LeadController::class, 'store'])->name('leads.store');

    Route::get('/services', function () {
        $servicesByCategory = \App\Models\Service::all()->groupBy('category');
        return view('partner.services', ['servicesByCategory' => $servicesByCategory]);
    })->name('services');

    Route::get('/earnings', function () {
        return view('earnings.index');
    })->name('earnings');

    Route::get('/referrals', function () {
        return view('referrals.index');
    })->name('referrals');

    Route::get('/training', function () {
        return view('partner.training');
    })->name('training');

    Route::get('/marketing', function () {
        return view('partner.marketing');
    })->name('marketing');

    Route::get('/kyc', [\App\Http\Controllers\KycController::class, 'index'])->name('kyc');
    Route::post('/kyc', [\App\Http\Controllers\KycController::class, 'store'])->name('kyc.store');
    Route::get('/kyc/id-card/download', [\App\Http\Controllers\KycController::class, 'downloadIdCard'])->name('kyc.download');

    Route::get('/withdrawals', [\App\Http\Controllers\WithdrawalController::class, 'index'])->name('withdrawals');
    Route::post('/withdrawals', [\App\Http\Controllers\WithdrawalController::class, 'store'])->name('withdrawals.store');

    Route::get('/tickets', [\App\Http\Controllers\TicketController::class, 'index'])->name('tickets');
    Route::get('/tickets/create', [\App\Http\Controllers\TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [\App\Http\Controllers\TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [\App\Http\Controllers\TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/message', [\App\Http\Controllers\TicketController::class, 'message'])->name('tickets.message');

    // Orders
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders');
    Route::get('/orders/create/{service}', [\App\Http\Controllers\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [\App\Http\Controllers\OrderController::class, 'invoice'])->name('orders.invoice');
    Route::post('/orders/{order}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});

// Legacy redirects so old bookmarks still work
Route::middleware(['auth'])->group(function () {
    Route::redirect('/dashboard', '/partner/dashboard', 301);
    Route::redirect('/leads', '/partner/leads', 301);
    Route::redirect('/withdrawals', '/partner/withdrawals', 301);
    Route::redirect('/kyc', '/partner/kyc', 301);
    Route::redirect('/referrals', '/partner/referrals', 301);
    Route::redirect('/tickets', '/partner/tickets', 301);
});

// Payment Routes
Route::get('/payment/create/{order}', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::post('/payment/verify', [PaymentController::class, 'verify'])->name('payment.verify');
Route::post('/webhook/razorpay', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Contact Routes
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', function (\Illuminate\Http\Request $r) {
    // Store or email contact — for now just redirect with success
    return redirect()->route('contact')->with('success', 'Thanks! We received your message and will contact you within 24 hours.');
})->name('contact.store');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/restore', [AdminUserController::class, 'restore'])->name('users.restore');
    Route::post('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads');
    Route::post('/leads/{lead}/status', [AdminLeadController::class, 'updateStatus'])->name('leads.status');
    Route::post('/leads/{lead}/approve', [AdminLeadController::class, 'approve'])->name('leads.approve');
    Route::delete('/leads/{lead}', [AdminLeadController::class, 'destroy'])->name('leads.destroy');
    Route::get('/kyc', [AdminKycController::class, 'index'])->name('kyc');
    Route::get('/kyc/{kyc}', [AdminKycController::class, 'show'])->name('kyc.show');
    Route::post('/kyc/{kyc}/approve', [AdminKycController::class, 'approve'])->name('kyc.approve');
    Route::post('/kyc/{kyc}/reject', [AdminKycController::class, 'reject'])->name('kyc.reject');
    Route::delete('/kyc/{kyc}', [AdminKycController::class, 'destroy'])->name('kyc.destroy');

    Route::get('/services', [AdminServiceController::class, 'index'])->name('services');
    Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

    // Admin: Banners
    Route::get('/banners', [\App\Http\Controllers\Admin\AdminBannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [\App\Http\Controllers\Admin\AdminBannerController::class, 'store'])->name('banners.store');
    Route::post('/banners/{banner}/toggle', [\App\Http\Controllers\Admin\AdminBannerController::class, 'toggle'])->name('banners.toggle');
    Route::delete('/banners/{banner}', [\App\Http\Controllers\Admin\AdminBannerController::class, 'destroy'])->name('banners.destroy');

    // Admin: CMS
    Route::get('/cms', [\App\Http\Controllers\Admin\AdminCmsController::class, 'index'])->name('cms.index');
    Route::post('/cms', [\App\Http\Controllers\Admin\AdminCmsController::class, 'store'])->name('cms.store');
    Route::get('/cms/{cms}/edit', [\App\Http\Controllers\Admin\AdminCmsController::class, 'edit'])->name('cms.edit');
    Route::put('/cms/{cms}', [\App\Http\Controllers\Admin\AdminCmsController::class, 'update'])->name('cms.update');
    Route::delete('/cms/{cms}', [\App\Http\Controllers\Admin\AdminCmsController::class, 'destroy'])->name('cms.destroy');

    // Admin: Orders
    Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [\App\Http\Controllers\Admin\AdminOrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Admin\AdminOrderController::class, 'status'])->name('orders.status');
    Route::delete('/orders/{order}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Admin: Support Tickets
    Route::get('/tickets', [\App\Http\Controllers\Admin\AdminTicketController::class, 'index'])->name('tickets');
    Route::get('/tickets/{ticket}', [\App\Http\Controllers\Admin\AdminTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/message', [\App\Http\Controllers\Admin\AdminTicketController::class, 'message'])->name('tickets.message');
    Route::post('/tickets/{ticket}/close', [\App\Http\Controllers\Admin\AdminTicketController::class, 'close'])->name('tickets.close');
    Route::post('/tickets/{ticket}/reopen', [\App\Http\Controllers\Admin\AdminTicketController::class, 'reopen'])->name('tickets.reopen');
    Route::post('/tickets/{ticket}/priority', [\App\Http\Controllers\Admin\AdminTicketController::class, 'priority'])->name('tickets.priority');
    Route::delete('/tickets/{ticket}', [\App\Http\Controllers\Admin\AdminTicketController::class, 'destroy'])->name('tickets.destroy');

    // Admin: Withdrawals
    Route::get('/withdrawals', [\App\Http\Controllers\Admin\AdminWithdrawalController::class, 'index'])->name('withdrawals');
    Route::post('/withdrawals/{withdrawal}/approve', [\App\Http\Controllers\Admin\AdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [\App\Http\Controllers\Admin\AdminWithdrawalController::class, 'reject'])->name('withdrawals.reject');
    Route::delete('/withdrawals/{withdrawal}', [\App\Http\Controllers\Admin\AdminWithdrawalController::class, 'destroy'])->name('withdrawals.destroy');


    Route::get('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'store'])->name('settings.store');
});
