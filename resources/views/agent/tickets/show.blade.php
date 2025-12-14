<x-app-layout>
  <x-slot name="header">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Ticket #{{ $ticket->id }}
        </h2>
        <p class="text-sm text-gray-500">
          {{ $ticket->name ?? $ticket->title ?? 'Ticket details' }}
        </p>
      </div>

      <div class="flex gap-2">
        <a href="{{ route('agent.tickets.index') }}"
          class="inline-flex items-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-800 shadow border border-gray-200 hover:bg-gray-50">
          Back
        </a>
      </div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="mb-4 rounded-lg border px-4 py-6" style="color: white; background-color: green; border-color: green;">
          {{ session('success') }}
        </div>
      @endif

      @php
        $status = $ticket->status ?? 'new';

        $badge = match ($status) {
          'new' => 'bg-blue-100 text-blue-800',
          'in_progress' => 'bg-amber-100 text-amber-800',
          'completed' => 'bg-green-100 text-green-800',
          default => 'bg-gray-100 text-gray-700',
        };

        $label = match ($status) {
          'new' => 'New',
          'in_progress' => 'In progress',
          'completed' => 'Completed',
          default => ucfirst(str_replace('_', ' ', $status)),
        };

        $nextStatus = match ($status) {
          'new' => 'in_progress',
          'in_progress' => 'completed',
          default => null,
        };

        $nextLabel = match ($nextStatus) {
          'in_progress' => 'Move to In progress',
          'completed' => 'Mark as Completed',
          default => null,
        };

        $nextBtnClass = match ($nextStatus) {
          'in_progress' => 'bg-amber-600 hover:bg-amber-700',
          'completed' => 'bg-green-600 hover:bg-green-700',
          default => 'bg-gray-300',
        };
      @endphp

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">

          <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
              <h3 class="text-lg font-semibold text-gray-900">Ticket information</h3>

              <div class="flex items-center start">
                <span class="text-sm text-gray-600">Current</span>
                <span class="inline-flex items-center rounded-full px-3 py-1 text-lg font-semibold {{ $badge }}">
                  {{ strtoupper($label) }}
                </span>

                @if ($nextStatus)
                  <form method="POST" action="{{ route('agent.tickets.setStatus', $ticket) }}">
                    @csrf
                    <input type="hidden" name="status" value="{{ $nextStatus }}">
                    <button type="submit"
                      class="w-full inline-flex justify-center rounded-lg px-4 py-2 text-sm font-semibold shadow {{ $nextBtnClass }}"
                      style="background-color: lightblue">
                      {{ $nextLabel }}
                    </button>
                  </form>
                @else
                  <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                    Ticket completed. No further transitions.
                  </div>
                @endif

              </div>
            </div>

            <div class="p-6 space-y-4">

              @if (!empty($ticket->description))
                <div>
                  <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Description
                  </div>
                  <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                    {{ $ticket->description }}
                  </div>
                </div>
              @endif

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-lg border border-gray-200 p-4">
                  <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Created by</div>
                  <div class="mt-1 text-sm text-gray-900">
                    {{ $ticket->user->name }}
                  </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-4">
                  <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Created at
                  </div>
                  <div class="mt-1 text-sm text-gray-900">
                    {{ $ticket->created_at->format('d/m/Y H:i') }}
                  </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-4">
                  <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Last updated
                  </div>
                  <div class="mt-1 text-sm text-gray-900">
                    {{ $ticket->updated_at->format('d/m/Y H:i') }}
                  </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div class="rounded-lg border border-gray-200 p-4">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                      Ticket type
                    </div>
                    <div class="mt-1 text-sm text-gray-900">
                      {{ $ticket->type ?? '—' }}
                    </div>
                  </div>

                  <div class="rounded-lg border border-gray-200 p-4">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                      Transport mode
                    </div>
                    <div class="mt-1 text-sm text-gray-900">
                      {{ $ticket->transport_mode ?? '—' }}
                    </div>
                  </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-4">
                  <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Origin country to Destination country
                  </div>
                  <div class="mt-1 text-sm text-gray-900">
                    {{ ucfirst($ticket->country_origin) }} to {{ ucfirst($ticket->country_destination) }}
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
              <h3 class="text-lg font-semibold text-gray-900">User documents</h3>
            </div>

            <div class="p-6">
              @if (($ticket->documents ?? collect())->isEmpty())
                <p class="text-gray-600">No documents uploaded yet.</p>
              @else
                <div class="space-y-3">
                  @foreach ($ticket->documents as $doc)
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 p-4">
                      <div>
                        <div class="text-sm font-semibold text-gray-900">
                          {{ $doc->name ?? $doc->title ?? basename($doc->path ?? '') ?? 'Document' }}
                        </div>
                        <div class="text-xs text-gray-500">
                          {{ optional($doc->created_at)->format('d/m/Y H:i') ?? '' }}
                        </div>
                      </div>

                      @if (!empty($doc->path))
                        <a href="{{ asset('storage/' . $doc->path) }}" target="_blank"
                          class="inline-flex items-center rounded-lg px-3 py-2 text-xs font-semibold"
                          style="background-color: lightblue">
                          Open
                        </a>
                      @endif
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>

          <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
              <h3 class="text-lg font-semibold text-gray-900">Document requests</h3>
            </div>

            <div class="p-6">

              <!-- Create Document Request form + button (inline style like your other buttons) -->
              <div class="mb-6 rounded-lg border border-gray-200 p-4">
                <form method="POST" action="{{ route('agent.documentRequests.store', $ticket) }}">
                  @csrf

                  <div class="grid grid-cols-1 gap-4">
                    <div>
                      <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</div>
                      <input type="text" name="title" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>

                    <div>
                      <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider py-2">Notes (optional)
                      </div>
                      <textarea name="notes" rows="3"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></textarea>
                    </div>

                    <div class="flex justify-end">
                      <button type="submit"
                        class="inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold shadow"
                        style="background-color: lightblue">
                        Create document request
                      </button>
                    </div>
                  </div>
                </form>
              </div>

              @if (($ticket->documentRequests ?? collect())->isEmpty())
                <p class="text-gray-600">No document requests yet.</p>
              @else
                <div class="space-y-3">
                  @foreach ($ticket->documentRequests as $req)

                    <div class="rounded-lg border border-gray-200 p-4">

                      <div class="text-sm font-semibold text-gray-900">
                        {{ $req->title ?? $req->name ?? 'Document request' }}
                      </div>
                      @if (!empty($req->description))
                        <div class="mt-1 text-sm text-gray-700 whitespace-pre-line">
                          {{ $req->description }}
                        </div>
                      @endif
                      @if (!empty($req->status))
                        <div class="mt-2 text-xs text-gray-500">
                          Status: {{ $req->status }}
                        </div>
                      @endif
                      <div class="mt-2 text-xs text-gray-500">
                        Created: {{ optional($req->created_at)->format('d/m/Y H:i') ?? '—' }}
                      </div>
                      @php
                        $requestDocs = ($ticket->documents ?? collect())->where('document_request_id', $req->id);
                      @endphp

                      <div class="mt-4">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                          Uploaded files for this request
                        </div>

                        @if ($requestDocs->isEmpty())
                          <div class="mt-1 text-sm text-gray-600">
                            No file uploaded yet.
                          </div>
                        @else
                          <div class="mt-2 space-y-2">
                            @foreach ($requestDocs as $doc)
                              <div class="flex items-center justify-start rounded-lg p-3">
                                <div class="text-sm font-semibold text-gray-900">
                                  {{ $doc->original_name ?? basename($doc->path ?? '') ?? 'Document' }}
                                </div>

                                @if (!empty($doc->path))
                                  <a href="{{ asset('storage/' . $doc->path) }}" target="_blank"
                                    class="inline-flex items-center rounded-lg ms-2 px-3 py-2 text-xs font-semibold"
                                    style="background-color: lightblue">
                                    Open
                                  </a>
                                @endif
                              </div>
                            @endforeach
                          </div>
                        @endif
                      </div>
                  @endforeach
                  </div>
              @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</x-app-layout>