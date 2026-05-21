<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminLeadController extends Controller
{
    // ─── LIST ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Lead::with('partner')->orderBy('created_at', 'desc');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('client_phone', 'like', "%{$search}%")
                  ->orWhere('id', $search)
                  ->orWhereHas('partner', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $leads = $query->paginate(15)->withQueryString();

        // Summary counts (real data)
        $needsReview = Lead::where('status', 'pending')->count();
        $inPipeline  = Lead::whereIn('status', ['contacted', 'negotiation'])->count();
        $closedWon   = Lead::where('status', 'won')
                           ->whereMonth('updated_at', now()->month)
                           ->count();
        $totalLeads  = Lead::count();
        $lostCount   = Lead::where('status', 'lost')->count();

        return view('admin.leads', compact(
            'leads', 'needsReview', 'inPipeline', 'closedWon', 'totalLeads', 'lostCount'
        ));
    }

    // ─── UPDATE STATUS ────────────────────────────────────────────────────────
    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,negotiation,won,lost',
        ]);

        $lead->update(['status' => $request->status]);

        return back()->with('success', "Lead status updated to " . ucfirst($request->status) . ".");
    }

    // ─── APPROVE (create order + redirect to payment) ─────────────────────────
    public function approve(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'final_amount' => 'required|numeric|min:0',
        ]);

        if ($lead->status === 'won') {
            return back()->withErrors(['status' => 'This lead is already won and processed.']);
        }

        DB::beginTransaction();
        try {
            $lead->update(['status' => 'negotiation']);

            // Find or create customer
            $customer = \App\Models\User::where('role', 'customer')
                ->where(function($q) use ($lead) {
                    $q->where('phone', $lead->client_phone);
                    if ($lead->client_email) {
                        $q->orWhere('email', $lead->client_email);
                    }
                })->first();

            if (!$customer) {
                // Auto-create customer user
                $customer = \App\Models\User::create([
                    'name'         => $lead->client_name,
                    'email'        => $lead->client_email ?? ($lead->client_phone . '@sksolution.local'),
                    'phone'        => $lead->client_phone,
                    'password'     => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
                    'role'         => 'customer',
                    'referred_by'  => $lead->partner_id,
                ]);
                \App\Models\Wallet::create(['user_id' => $customer->id]);
            }

            // Find service
            $service = \App\Models\Service::where('name', $lead->service_needed)->first();
            $serviceId = $service ? $service->id : null;

            $order = Order::create([
                'lead_id'             => $lead->id,
                'user_id'             => $customer->id,
                'service_id'          => $serviceId,
                'amount'              => $validated['final_amount'],
                'status'              => 'pending',
                'customer_name'       => $lead->client_name,
                'customer_phone'      => $lead->client_phone,
                'customer_email'      => $lead->client_email,
                'company_name'        => $lead->company_name,
                'referred_by_partner' => $lead->partner_id,
                'requirements'        => $lead->notes ?? 'Approved lead order',
            ]);

            // Create order item
            if ($service) {
                \App\Models\OrderItem::create([
                    'order_id'   => $order->id,
                    'service_id' => $service->id,
                    'price'      => $validated['final_amount'],
                    'quantity'   => 1,
                    'subtotal'   => $validated['final_amount'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.leads')
                ->with('success', 'Lead approved and order created successfully! Customer can now view and pay for the order from their dashboard.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed: ' . $e->getMessage()]);
        }
    }

    // ─── DELETE ──────────────────────────────────────────────────────────────
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return back()->with('success', 'Lead deleted.');
    }
}
