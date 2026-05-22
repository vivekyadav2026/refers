<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'phone', 'role', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pin',
        'phone',
        'role',
        'referred_by',
        'referral_code',
        'company_name',
        'business_type',
        'kyc_status',
        'status',
        'avatar',
        'alternate_phone',
        'gender',
        'address_house',
        'address_street',
        'address_city',
        'address_state',
        'address_pin',
        'address_country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'pin',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'partner_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function partnerReferrals()
    {
        return $this->hasMany(PartnerReferral::class, 'partner_id');
    }

    public function kycDocument()
    {
        return $this->hasOne(KycDocument::class, 'user_id');
    }

    /**
     * Check if user is admin or sub admin.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'sub_admin']);
    }

    /**
     * Check if user is specifically a sub admin.
     */
    public function isSubAdmin(): bool
    {
        return $this->role === 'sub_admin';
    }

    /**
     * Check if user is partner.
     */
    public function isPartner(): bool
    {
        return $this->role === 'partner';
    }

    /**
     * Check if user is customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Generate referral link for V-Partner.
     */
    public function getReferralLinkAttribute(): string
    {
        return url('/ref/' . $this->referral_code);
    }
}
