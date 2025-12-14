<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketDocument;
use App\Models\DocumentRequest;
use Illuminate\Support\Facades\Storage;
use App\Notifications\GenericNotification;

class TicketDocumentController extends Controller
{
    /* The Ticket Document Controller has TODO

        1. Upload documents to a ticket
        2. Upload documents requested by an agent

        1) Upload document to a ticket
        -- Allow user to upload a document
        -- Associate document with a ticket
        -- Store file path and metadata
        -- Register who uploaded the document

        2) Upload document for a document request
        -- Allow user to upload a document requested by an agent
        -- Associate document with a document request

    */

    public function store(Request $request, Ticket $ticket)
    {
        if ((int) $ticket->user_id !== (int) $request->user()->id) {
            abort(403, 'You are not allowed to upload documents to this ticket.');
        }

        $data = $request->validate([
            'document' => ['required', 'file', 'max:5120'],
        ]);

        $file = $data['document'];

        $path = $file->store("tickets/{$ticket->id}", 'public');

        TicketDocument::create([
            'ticket_id' => $ticket->id,
            'document_request_id' => null,
            'uploaded_by' => $request->user()->id,
            'path' => $path,
            'name' => $file->getClientOriginalName(),
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Document uploaded successfully.');
    }

    public function uploadForRequest(Request $request, DocumentRequest $documentRequest)
    {
        $ticket = $documentRequest->ticket;

        if (!$ticket) {
            abort(404, 'Ticket not found for this document request.');
        }

        if ((int) $ticket->user_id !== (int) $request->user()->id) {
            abort(403, 'You are not allowed to upload documents for this request.');
        }

        $data = $request->validate([
            'document' => ['required', 'file', 'max:5120'],
        ]);

        $file = $data['document'];

        $path = $file->store("tickets/{$ticket->id}/requests/{$documentRequest->id}", 'public');

        TicketDocument::create([
            'ticket_id' => $ticket->id,
            'document_request_id' => $documentRequest->id,
            'uploaded_by' => $request->user()->id,
            'path' => $path,
            'name' => $file->getClientOriginalName(),
        ]);

        $documentRequest->update([
            'status' => 'uploaded',
        ]);

        if ($documentRequest->agent) {
            $documentRequest->agent->notify(
                new GenericNotification("User uploaded a document for request #{$documentRequest->id} (Ticket #{$ticket->id})")
            );
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Requested document uploaded successfully.');
    }


}
