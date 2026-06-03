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
use App\Http\Controllers\Admin\AdminCommissionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\ReferralController;
use App\Models\Service;

Route::get('/', function () {
    $banners = \App\Models\Banner::where('is_active', true)->latest()->get();
    
    $orderedSlugs = [
        'e-commerce-website-design-development',
        'informative-website-design-development',
        'e-commerce-mobile-app-development',
        'grocery-mobile-app-development',
        'food-delivery-mobile-app-development',
        'meta-ads',
        'google-ads',
        'seo-search-engine-optimization',
        'reels-video-editing'
    ];

    $services = \App\Models\Service::where('is_active', true)->get();
    
    // Sort by the predefined slug order
    $services = $services->sortBy(function ($service) use ($orderedSlugs) {
        $pos = array_search($service->slug, $orderedSlugs);
        return $pos === false ? 999 : $pos;
    });

    $popularServices = $services->where('is_popular', true)->take(4);
    $servicesByCategory = $services->groupBy('category');
    $categories = \App\Models\Service::where('is_active', true)->distinct()->pluck('category');
    
    return view('welcome', compact('banners', 'popularServices', 'servicesByCategory', 'categories', 'services'));
})->name('landing');

// ─── REFERRAL LINK ────────────────────────────────────────────────────────
Route::get('/ref/{code}', [ReferralController::class, 'handleReferral'])->name('referral.link');

// ─── AUTH ROUTES ──────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showCustomerLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showCustomerRegister'])->name('register');
Route::get('/partner-login', [AuthController::class, 'showPartnerLogin'])->name('partner.login');
Route::get('/partner-register', [AuthController::class, 'showPartnerRegister'])->name('partner.register');

// Phone OTP login (for customers + partners)
Route::post('/login/send-otp', [AuthController::class, 'sendOtp'])->name('login.send_otp');
Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify.show');
Route::post('/verify', [AuthController::class, 'verifyOtp'])->name('verify.check');
Route::get('/login/pin', [AuthController::class, 'showPinLogin'])->name('login.pin.show');
Route::post('/login/pin', [AuthController::class, 'loginWithPin'])->name('login.pin.submit');

// Admin: Email + Password login
Route::get('/admin-login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin-login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── PUBLIC SERVICE ROUTES ────────────────────────────────────────────────
Route::get('/services', function () {
    $query = Service::where('is_active', true);
    if (request()->filled('search')) {
        $search = request('search');
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%')
              ->orWhere('category', 'like', '%' . $search . '%');
        });
    }
    $allSvcs = $query->get();
    
    $orderedSlugs = [
        'e-commerce-website-design-development',
        'informative-website-design-development',
        'e-commerce-mobile-app-development',
        'grocery-mobile-app-development',
        'food-delivery-mobile-app-development',
        'meta-ads',
        'google-ads',
        'seo-search-engine-optimization',
        'reels-video-editing'
    ];
    
    $allSvcs = $allSvcs->sortBy(function ($service) use ($orderedSlugs) {
        $pos = array_search($service->slug, $orderedSlugs);
        return $pos === false ? 999 : $pos;
    });

    $allCategories = Service::where('is_active', true)->distinct()->pluck('category');
    return view('services.index', ['allSvcs' => $allSvcs, 'allCategories' => $allCategories, 'selectedCategory' => request('category')]);
})->name('services.index');

Route::get('/portfolio', [\App\Http\Controllers\PortfolioController::class, 'index'])->name('portfolio');

Route::get('/services/{slug}', function ($slug) {
    $service = Service::where('slug', $slug)->firstOrFail();
    $activeCoupons = \App\Models\Coupon::where('is_active', true)
        ->where(function($q) use ($service) {
            $q->whereNull('service_id')->orWhere('service_id', $service->id);
        })
        ->where(function($q) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
        })
        ->get();
    return view('services.show', ['service' => $service, 'activeCoupons' => $activeCoupons]);
})->name('services.show')->middleware('auth:customer,partner,admin');

// ─── CUSTOMER ROUTES ──────────────────────────────────────────────────────
Route::middleware(['auth:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [CustomerDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [CustomerDashboardController::class, 'orderShow'])->name('order.show');
    Route::get('/orders/{order}/invoice', [\App\Http\Controllers\OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/profile', [CustomerDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerDashboardController::class, 'updateProfile'])->name('profile.update');

    Route::get('/services', function () {
        $query = \App\Models\Service::where('is_active', true);
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }
        $services = $query->get();
        
        $orderedSlugs = [
            'e-commerce-website-design-development',
            'informative-website-design-development',
            'e-commerce-mobile-app-development',
            'grocery-mobile-app-development',
            'food-delivery-mobile-app-development',
            'meta-ads',
            'google-ads',
            'seo-search-engine-optimization',
            'reels-video-editing'
        ];
        
        $services = $services->sortBy(function ($service) use ($orderedSlugs) {
            $pos = array_search($service->slug, $orderedSlugs);
            return $pos === false ? 999 : $pos;
        });

        $allCategories = \App\Models\Service::where('is_active', true)->distinct()->pluck('category');
        return view('customer.services', [
            'services'         => $services,
            'allCategories'    => $allCategories,
            'selectedCategory' => request('category'),
        ]);
    })->name('services');

    // Business Details Form
    Route::get('/orders/{order}/business-details', [\App\Http\Controllers\BusinessDetailController::class, 'create'])->name('business-details.create');
    Route::post('/orders/{order}/business-details', [\App\Http\Controllers\BusinessDetailController::class, 'store'])->name('business-details.store');
});

// ─── CART ROUTES ──────────────────────────────────────────────────────────
Route::middleware(['auth:customer'])->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::delete('/{cart}', [CartController::class, 'remove'])->name('remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('processCheckout');
});

// ─── PARTNER ROUTES ───────────────────────────────────────────────────────
Route::middleware(['auth:partner'])->prefix('partner')->name('partner.')->group(function () {
    // Unlocked onboarding/verification routes
    Route::get('/apply', [\App\Http\Controllers\PartnerOnboardingController::class, 'index'])->name('apply');
    Route::post('/apply', [\App\Http\Controllers\PartnerOnboardingController::class, 'store'])->name('apply.store');

    Route::get('/kyc', [\App\Http\Controllers\KycController::class, 'index'])->name('kyc');
    Route::post('/kyc', [\App\Http\Controllers\KycController::class, 'store'])->name('kyc.store');
    Route::get('/kyc/id-card/download', [\App\Http\Controllers\KycController::class, 'downloadIdCard'])->name('kyc.download');
    Route::get('/agreement/download', [\App\Http\Controllers\KycController::class, 'downloadAgreement'])->name('agreement.download');

    // Locked partner panel routes (requires Step 1 and Approved KYC)
    Route::middleware(['partner.unlock'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [\App\Http\Controllers\DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [\App\Http\Controllers\DashboardController::class, 'updateProfile'])->name('profile.update');

        Route::get('/leads', [\App\Http\Controllers\LeadController::class, 'index'])->name('leads.index');
        Route::get('/leads/create', [\App\Http\Controllers\LeadController::class, 'create'])->name('leads.create');
        Route::post('/leads', [\App\Http\Controllers\LeadController::class, 'store'])->name('leads.store');

        Route::get('/services', function () {
            $query = \App\Models\Service::where('is_active', true);
            if (request('search')) {
                $query->where('name', 'like', '%' . request('search') . '%');
            }
            $servicesByCategory = $query->get()->groupBy('category');
            return view('partner.services', ['servicesByCategory' => $servicesByCategory]);
        })->name('services');

        Route::get('/earnings', function () {
            $user = auth()->user();

            $commissions = \App\Models\Commission::with(['order.service', 'order.user'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);

            $totalEarned    = \App\Models\Commission::where('user_id', $user->id)->whereIn('status', ['cleared', 'paid'])->sum('amount');
            $pendingAmount  = \App\Models\Commission::where('user_id', $user->id)->where('status', 'pending')->sum('amount');
            $paidAmount     = \App\Models\Commission::where('user_id', $user->id)->where('status', 'paid')->sum('amount');
            $walletBalance  = $user->wallet?->balance ?? 0;
            $totalSales     = \App\Models\Commission::where('user_id', $user->id)->count();

            return view('earnings.index', compact(
                'commissions', 'totalEarned', 'pendingAmount', 'paidAmount', 'walletBalance', 'totalSales'
            ));
        })->name('earnings');

        Route::get('/referrals', function () {
            $user = auth()->user();
            $referrals = \App\Models\PartnerReferral::where('partner_id', $user->id)
                ->with(['customer', 'order.service'])
                ->latest()
                ->paginate(15);
            $totalClicks = \App\Models\PartnerReferral::where('partner_id', $user->id)->count();
            $totalRegistrations = \App\Models\PartnerReferral::where('partner_id', $user->id)->where('status', 'registered')->count();
            $totalPurchases = \App\Models\PartnerReferral::where('partner_id', $user->id)->where('status', 'purchased')->count();
            return view('referrals.index', compact('referrals', 'totalClicks', 'totalRegistrations', 'totalPurchases'));
        })->name('referrals');

        Route::get('/training', function () {
            $trainings = \App\Models\Training::where('is_active', true)->orderBy('order_column')->get();
            return view('partner.training', compact('trainings'));
        })->name('training');

        Route::get('/marketing', function () {
            $materials = \App\Models\MarketingMaterial::where('is_active', true)->latest()->get();
            return view('partner.marketing', compact('materials'));
        })->name('marketing');

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

        // Post-Payment Form
        Route::get('/orders/{order}/details', [\App\Http\Controllers\PostPaymentController::class, 'create'])->name('post-payment.create');
        Route::post('/orders/{order}/details', [\App\Http\Controllers\PostPaymentController::class, 'store'])->name('post-payment.store');
        Route::post('/orders/{order}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    });
});

// Legacy redirects so old bookmarks still work
Route::middleware(['auth:customer,partner,admin'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if (in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'partner') {
            return redirect()->route('partner.dashboard');
        }
        return redirect()->route('customer.dashboard');
    });
    Route::redirect('/leads', '/partner/leads', 301);
    Route::redirect('/withdrawals', '/partner/withdrawals', 301);
    Route::redirect('/kyc', '/partner/kyc', 301);
    Route::redirect('/referrals', '/partner/referrals', 301);
    Route::redirect('/tickets', '/partner/tickets', 301);
});

// ─── PAYMENT ROUTES ───────────────────────────────────────────────────────
Route::get('/payment/create/{order}', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::post('/payment/verify', [PaymentController::class, 'verify'])->name('payment.verify');
Route::post('/webhook/razorpay', [PaymentController::class, 'webhook'])->name('payment.webhook');
Route::post('/buy-now', [PaymentController::class, 'buyNow'])->name('payment.buyNow')->middleware('auth:customer');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-and-condition', function () {
    return view('terms-and-condition');
})->name('terms-and-condition');

Route::get('/terms-and-conditions', function () {
    return redirect()->route('terms-and-condition');
});

Route::get('/refund-policy', function () {
    return view('refund-policy');
})->name('refund-policy');

// ─── CONTACT ROUTES ───────────────────────────────────────────────────────
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', function (\Illuminate\Http\Request $r) {
    // Store or email contact — for now just redirect with success
    return redirect()->route('contact')->with('success', 'Thanks! We received your message and will contact you within 24 hours.');
})->name('contact.store');

// ─── ADMIN ROUTES ─────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/customers', [AdminUserController::class, 'customers'])->name('customers');
    Route::get('/partners', [AdminUserController::class, 'partners'])->name('partners');
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
    Route::post('/services/{service}/toggle', [AdminServiceController::class, 'toggle'])->name('services.toggle');

    // Admin: Banners
    Route::get('/banners', [\App\Http\Controllers\Admin\AdminBannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [\App\Http\Controllers\Admin\AdminBannerController::class, 'store'])->name('banners.store');
    Route::put('/banners/{banner}', [\App\Http\Controllers\Admin\AdminBannerController::class, 'update'])->name('banners.update');
    Route::post('/banners/{banner}/toggle', [\App\Http\Controllers\Admin\AdminBannerController::class, 'toggle'])->name('banners.toggle');
    Route::delete('/banners/{banner}', [\App\Http\Controllers\Admin\AdminBannerController::class, 'destroy'])->name('banners.destroy');



    // Admin: Orders
    Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [\App\Http\Controllers\Admin\AdminOrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Admin\AdminOrderController::class, 'status'])->name('orders.status');
    Route::delete('/orders/{order}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/{order}/invoice', [\App\Http\Controllers\OrderController::class, 'invoice'])->name('orders.invoice');

    // Admin: Post-Payments
    Route::get('/post-payments', [\App\Http\Controllers\Admin\AdminPostPaymentController::class, 'index'])->name('post-payments.index');
    Route::get('/post-payments/export', [\App\Http\Controllers\Admin\AdminPostPaymentController::class, 'export'])->name('post-payments.export');

    // Admin: Commissions
    Route::get('/commissions', [AdminCommissionController::class, 'index'])->name('commissions');
    Route::post('/commissions/{commission}/approve', [AdminCommissionController::class, 'approve'])->name('commissions.approve');
    Route::post('/commissions/{commission}/reject', [AdminCommissionController::class, 'reject'])->name('commissions.reject');
    Route::post('/commissions/{commission}/paid', [AdminCommissionController::class, 'markPaid'])->name('commissions.paid');
    Route::get('/referral-analytics', [AdminCommissionController::class, 'analytics'])->name('referral.analytics');

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

    // Admin: Marketing Materials
    Route::resource('marketing', \App\Http\Controllers\Admin\AdminMarketingMaterialController::class);

    // Admin: Training Center
    Route::get('/training', [\App\Http\Controllers\Admin\AdminTrainingController::class, 'index'])->name('training.index');
    Route::post('/training', [\App\Http\Controllers\Admin\AdminTrainingController::class, 'store'])->name('training.store');
    Route::put('/training/{training}', [\App\Http\Controllers\Admin\AdminTrainingController::class, 'update'])->name('training.update');
    Route::delete('/training/{training}', [\App\Http\Controllers\Admin\AdminTrainingController::class, 'destroy'])->name('training.destroy');
    Route::post('/training/{training}/toggle', [\App\Http\Controllers\Admin\AdminTrainingController::class, 'toggle'])->name('training.toggle');

    // Admin: Portfolios
    Route::resource('portfolios', \App\Http\Controllers\Admin\AdminPortfolioController::class);
    Route::post('/portfolios/{portfolio}/toggle', [\App\Http\Controllers\Admin\AdminPortfolioController::class, 'toggle'])->name('portfolios.toggle');



    // Admin: Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\AdminCouponController::class);

    Route::get('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'store'])->name('settings.store');

    // Admin: Custom Notifications
    Route::get('/send-notifications', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'create'])->name('notifications.create');
    Route::post('/send-notifications', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'store'])->name('notifications.store');
});

// ─── NOTIFICATIONS ────────────────────────────────────────────────────────
Route::middleware(['auth:customer,partner,admin'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::post('/{id}/read', function ($id) {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        $notif = auth()->user()->notifications()->where('id', $id)->first();
        $url = $notif?->data['url'] ?? url('/');
        return redirect($url);
    })->name('read');

    Route::post('/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('read.all');
});

// Temporary Route to Fix Storage Links on Live Server without SSH Access
Route::get('/fix-storage', function () {
    try {
        // Delete the broken public/storage directory or symlink
        if (file_exists(public_path('storage'))) {
            \Illuminate\Support\Facades\File::deleteDirectory(public_path('storage'));
        }
        
        // Run the artisan command
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        
        return 'Storage link fixed! Images should now display correctly. Please delete this route from routes/web.php once confirmed.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return 'Cache cleared successfully';
});
