<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;

class AdminTicketController extends Controller
{
    // ─── LIST ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = SupportTicket::with(['user'])
            ->withCount('messages')
            ->latest();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('id', $search)
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                                                    ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Priority filter
        if ($priority = $request->input('priority')) {
            $query->where('priority', $priority);
        }

        $tickets = $query->paginate(15)->withQueryString();

        // Summary counts
        $totalTickets    = SupportTicket::count();
        $openCount       = SupportTicket::where('status', 'open')->count();
        $inProgressCount = SupportTicket::where('status', 'in_progress')->count();
        $closedCount     = SupportTicket::where('status', 'closed')->count();
        $highPriority    = SupportTicket::where('priority', 'high')->where('status', '!=', 'closed')->count();

        return view('admin.tickets.index', compact(
            'tickets', 'totalTickets', 'openCount', 'inProgressCount', 'closedCount', 'highPriority'
        ));
    }

    // ─── SHOW / CONVERSATION ─────────────────────────────────────────────────
    public function show(SupportTicket $ticket)
    {
        $ticket->load(['messages.user', 'user']);
        return view('admin.tickets.show', compact('ticket'));
    }

    // ─── REPLY ───────────────────────────────────────────────────────────────
    public function message(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        // Auto-move to in_progress on first admin reply
        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Reply sent.');
    }

    // ─── CLOSE ───────────────────────────────────────────────────────────────
    public function close(SupportTicket $ticket)
    {
        $ticket->update(['status' => 'closed']);
        return back()->with('success', 'Ticket #TKT-' . str_pad($ticket->id, 5, '0', STR_PAD_LEFT) . ' closed.');
    }

    // ─── REOPEN ──────────────────────────────────────────────────────────────
    public function reopen(SupportTicket $ticket)
    {
        $ticket->update(['status' => 'open']);
        return back()->with('success', 'Ticket reopened.');
    }

    // ─── UPDATE PRIORITY ─────────────────────────────────────────────────────
    public function priority(Request $request, SupportTicket $ticket)
    {
        $request->validate(['priority' => 'required|in:low,medium,high']);
        $ticket->update(['priority' => $request->priority]);
        return back()->with('success', 'Priority updated.');
    }

    // ─── DELETE ──────────────────────────────────────────────────────────────
    public function destroy(SupportTicket $ticket)
    {
        $ticketId = str_pad($ticket->id, 5, '0', STR_PAD_LEFT);
        $ticket->delete(); // messages cascade via DB
        return redirect()->route('admin.tickets')
            ->with('success', "Ticket #TKT-{$ticketId} deleted.");
    }
}
