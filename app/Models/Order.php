<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'amount'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected $fillable = [
        'lead_id', 'user_id', 'service_id', 'amount', 'status', 'requirements',
        'customer_name', 'customer_email', 'customer_phone',
        'company_name', 'business_type', 'file_upload',
        'razorpay_order_id', 'razorpay_payment_id', 'referred_by_partner',
        'platform_choice', 'platform_price', 'domain_choice', 'domain_charge', 'gst_amount',
        'coupon_code', 'coupon_discount',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function referringPartner()
    {
        return $this->belongsTo(User::class, 'referred_by_partner');
    }

    public function partnerReferral()
    {
        return $this->hasOne(PartnerReferral::class);
    }

    public function businessDetail()
    {
        return $this->hasOne(BusinessDetail::class);
    }

    public function postPaymentDetail()
    {
        return $this->hasOne(PostPaymentDetail::class);
    }
}
