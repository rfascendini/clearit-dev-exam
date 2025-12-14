<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GenericNotification;
use App\Models\Ticket;
use App\Models\DocumentRequest;

class DocumentRequestController extends Controller
{
    /*
    The Document Request Controller has TODO

    1. Create document requests for a ticket

    1) Create document request
    -- Allow agent to request additional documentation
    -- Associate request with a ticket
    -- Define requested document title
    -- Optional notes or instructions
    -- Notify the user about the document request
    */

    public function store(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $documentRequest = DocumentRequest::create([
            'ticket_id' => $ticket->id,
            'agent_id' => $request->user()->id,
            'title' => $data['title'],
            'notes' => $data['notes'] ?? null,
            'status' => 'requested',
        ]);

        if ($ticket->user) {
            $ticket->user->notify(
                new GenericNotification("Document requested for Ticket #{$ticket->id}: {$documentRequest->title}")
            );
        }

        return redirect()
            ->route('agent.tickets.show', $ticket)
            ->with('success', 'Document request created successfully.');
    }
}


