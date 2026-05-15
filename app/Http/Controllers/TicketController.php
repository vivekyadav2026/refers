<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->supportTickets()->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $tickets = $query->paginate(10)->withQueryString();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'message' => 'required|string',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'priority' => $request->priority,
            'status' => 'open',
        ]);

        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('partner.tickets.show', $ticket)->with('success', 'Ticket #TKT-' . str_pad($ticket->id, 5, '0', STR_PAD_LEFT) . ' created! We\'ll respond shortly.');
    }

    public function show(SupportTicket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) abort(403);
        
        $ticket->load('messages.user');
        return view('tickets.show', compact('ticket'));
    }

    public function message(Request $request, SupportTicket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) abort(403);

        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent.');
    }
}
