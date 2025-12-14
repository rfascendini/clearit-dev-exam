<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GenericNotification;
use App\Models\Ticket;

class AgentTicketController extends Controller
{
    /*
    The Agent Ticket Controller has TODO

    1. Show tickets
    2. Show ticket details
    3. Update ticket status

    1) Show tickets
    -- List all tickets

    2) Show details of a ticket
    -- Ticket basic information
    -- Current status
    -- Documents uploaded by the user
    -- Document requests created by the agent

    3) Update ticket status
    -- Allowed transitions:
    - Change status from new => in_progress
    - Change status from in_progress => completed
    -- Notify the user when the status changes

    */


    public function index(Request $request)
{
    $tickets = Ticket::with('user')->latest()->get();

    return view('agent.tickets.index', compact('tickets'));
}

public function show(Request $request, Ticket $ticket)
{
    $ticket->load(['user', 'documents', 'documentRequests']);

    return view('agent.tickets.show', compact('ticket'));
}

public function setStatus(Request $request, Ticket $ticket)
{
    $data = $request->validate([
        'status' => ['required', 'string', 'in:new,in_progress,completed'],
    ]);

    $newStatus = $data['status'];

    $current = $ticket->status;

    $allowed = [
        Ticket::STATUS_NEW => [Ticket::STATUS_IN_PROGRESS],
        Ticket::STATUS_IN_PROGRESS => [Ticket::STATUS_COMPLETED],
        Ticket::STATUS_COMPLETED => [],
    ];

    if (!in_array($newStatus, $allowed[$current] ?? [], true)) {
        abort(422, "Invalid status transition from {$current} to {$newStatus}.");
    }

    $ticket->update(['status' => $newStatus]);

    if ($ticket->user) {
        $ticket->user->notify(
            new GenericNotification("Ticket #{$ticket->id} status updated to {$ticket->status}")
        );
    }

    return redirect()
        ->route('agent.tickets.show', $ticket)
        ->with('success', 'Ticket status updated successfully.');
}


}
