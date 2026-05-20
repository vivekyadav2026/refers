<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::where('partner_id', Auth::id())
            ->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_phone', 'like', "%{$search}%")
                  ->orWhere('service_needed', 'like', "%{$search}%");
            });
        }

        $leads = $query->paginate(10)->withQueryString();

        $stats = [
            'total'    => Lead::where('partner_id', Auth::id())->count(),
            'pending'  => Lead::where('partner_id', Auth::id())->where('status', 'pending')->count(),
            'won'      => Lead::where('partner_id', Auth::id())->where('status', 'won')->count(),
            'lost'     => Lead::where('partner_id', Auth::id())->where('status', 'lost')->count(),
        ];

        return view('leads.index', compact('leads', 'stats'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->get();
        return view('leads.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'     => 'required|string|max:255',
            'client_phone'    => 'required|string|max:20',
            'client_email'    => 'nullable|email|max:255',
            'company_name'    => 'nullable|string|max:255',
            'service_needed'  => 'required|string|max:255',
            'estimated_value' => 'nullable|numeric|min:0',
            'notes'           => 'nullable|string|max:1000',
        ]);

        $service = Service::where('name', $validated['service_needed'])->first();
        $estimatedValue = $validated['estimated_value'] ?? ($service ? $service->min_price : 0);

        Lead::create([
            'partner_id'      => Auth::id(),
            'client_name'     => $validated['client_name'],
            'client_phone'    => $validated['client_phone'],
            'client_email'    => $validated['client_email'] ?? null,
            'company_name'    => $validated['company_name'] ?? null,
            'service_needed'  => $validated['service_needed'],
            'estimated_value' => $estimatedValue,
            'notes'           => $validated['notes'] ?? null,
            'status'          => 'pending',
        ]);

        return redirect()->route('partner.leads.index')->with('success', 'Lead submitted successfully! Our team will review it shortly.');
    }
}
