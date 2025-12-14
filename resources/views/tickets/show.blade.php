<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Ticket #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">

        <div>
            <strong>Name:</strong> {{ $ticket->name }}<br>
            <strong>Status:</strong> {{ $ticket->status }}<br>
            <strong>Type:</strong> {{ $ticket->type }}<br>
            <strong>Transport:</strong> {{ $ticket->transport_mode }}<br>
            <strong>Product:</strong> {{ $ticket->product }}<br>
            <strong>Origin:</strong> {{ $ticket->country_origin }}<br>
            <strong>Destination:</strong> {{ $ticket->country_destination }}
        </div>

        <hr>

        <h3><strong>Upload a document to this ticket</strong></h3>

        <form method="POST" action="{{ route('tickets.documents.store', $ticket) }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="document" required>
            <button type="submit" style="background-color: #3b82f6; color: white; padding: 8px 12px; border-radius: 4px; border: none;">Upload</button>
        </form>

        <hr>

        <h3><strong>Documents</strong></h3>

        @if ($ticket->documents->isEmpty())
            <p>No documents uploaded.</p>
        @else
            <ul>
                @foreach ($ticket->documents as $doc)
                    <li>
                        {{ $doc->original_name ?? ('Document #' . $doc->id) }}
                        @if (!empty($doc->path))
                            — <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" style="background-color: darkblue; color: white; padding: 8px 12px; border-radius: 4px; border: none;">View</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <hr>

        <h3><strong>Document Requests</strong></h3>

        @if ($ticket->documentRequests->isEmpty())
            <p>No document requests.</p>
        @else
            @foreach ($ticket->documentRequests as $req)
                <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                    <div><strong>Request:</strong> {{ $req->title ?? ('Request #' . $req->id) }}</div>
                    @if (!empty($req->notes))
                        <div><strong>Notes:</strong> {{ $req->notes }}</div>
                    @endif
                    @if (!empty($req->status))
                        <div><strong>Status:</strong> {{ $req->status }}</div>
                    @endif

                    <form method="POST" action="{{ route('documentRequests.upload', $req) }}" enctype="multipart/form-data" style="margin-top:10px;">
                        @csrf
                        <input type="file" name="document" required>
                        <button type="submit" style="background-color: green; color: white; padding: 8px 12px; border-radius: 4px; border: none;">Upload for this request</button>
                    </form>
                </div>
            @endforeach
        @endif

        <div>
            <a href="{{ route('tickets.index') }}" style="background-color: gray; color: #FFFFFF; padding: 8px 12px; border-radius: 4px; text-decoration: none;">Back to Tickets</a>
        </div>

    </div>
</x-app-layout>
