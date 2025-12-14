<x-app-layout>
  <x-slot name="header">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Ticket #{{ $ticket->id }}
        </h2>
        <p class="text-sm text-gray-500">
          {{ $ticket->name ?? $ticket->title ?? 'Ticket details' }}
        </p>
      </div>

      <div class="flex gap-2">
        <a
          href="{{ route('agent.tickets.index') }}"
          class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Back
        </a>
      </div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
          {{ session('success') }}
        </div>
      @endif

      @php
        $status = $ticket->status ?? 'new';

        $badge = match ($status) {
          'new' => 'bg-blue-100 text-blue-800 ring-blue-200',
          'in_progress' => 'bg-amber-100 text-amber-800 ring-amber-200',
          'completed' => 'bg-green-100 text-green-800 ring-green-200',
          default => 'bg-gray-100 text-gray-700 ring-gray-200',
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
          'in_progress' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
          'completed' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
          default => 'bg-gray-300',
        };
      @endphp

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">

          {{-- Ticket information --}}
          <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
              <h3 class="text-lg font-semibold text-gray-900">Ticket information</h3>

              <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-600">Current</span>

                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase ring-1 ring-inset {{ $badge }}">
                  {{ $label }}
                </span>

                @if ($nextStatus)
                  <form method="POST" action="{{ route('agent.tickets.setStatus', $ticket) }}">
                    @csrf
                    <input type="hidden" name="status" value="{{ $nextStatus }}">

                    <button
                      type="submit"
                      class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $nextBtnClass }}"
                    >
                      {{ $nextLabel }}
                    </button>
                  </form>
                @else
                  <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-700">
                    Ticket completed. No further transitions.
                  </div>
                @endif
              </div>
            </div>

            <div class="space-y-4 p-6">
              @if (!empty($ticket->description))
                <div>
                  <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Description</div>
                  <div class="mt-1 whitespace-pre-line text-sm text-gray-900">
                    {{ $ticket->description }}
                  </div>
                </div>
              @endif

              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-lg border border-gray-200 p-4">
                  <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Created by</div>
                  <div class="mt-1 text-sm text-gray-900">
                    {{ $ticket->user->name ?? '—' }}
                  </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-4">
                  <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Created at</div>
                  <div class="mt-1 text-sm text-gray-900">
                    {{ optional($ticket->created_at)->format('d/m/Y H:i') ?? '—' }}
                  </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-4">
                  <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Last updated</div>
                  <div class="mt-1 text-sm text-gray-900">
                    {{ optional($ticket->updated_at)->format('d/m/Y H:i') ?? '—' }}
                  </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                  <div class="rounded-lg border border-gray-200 p-4">
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Ticket type</div>
                    <div class="mt-1 text-sm text-gray-900">
                      {{ $ticket->type ?? '—' }}
                    </div>
                  </div>

                  <div class="rounded-lg border border-gray-200 p-4">
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Transport mode</div>
                    <div class="mt-1 text-sm text-gray-900">
                      {{ $ticket->transport_mode ?? '—' }}
                    </div>
                  </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-4 sm:col-span-2">
                  <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Origin country to Destination country
                  </div>
                  <div class="mt-1 text-sm text-gray-900">
                    {{ ucfirst($ticket->country_origin ?? '') }} to {{ ucfirst($ticket->country_destination ?? '') }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- User documents --}}
          <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
              <h3 class="text-lg font-semibold text-gray-900">User documents</h3>
            </div>

            <div class="p-6">
              @if (($ticket->documents ?? collect())->isEmpty())
                <p class="text-gray-600">No documents uploaded yet.</p>
              @else
                <div class="space-y-3">
                  @foreach ($ticket->documents as $doc)
                    <div class="flex flex-col gap-3 rounded-lg border border-gray-200 p-4 sm:flex-row sm:items-center sm:justify-between">
                      <div>
                        <div class="text-sm font-semibold text-gray-900">
                          {{ $doc->name ?? $doc->title ?? basename($doc->path ?? '') ?? 'Document' }}
                        </div>
                        <div class="text-xs text-gray-500">
                          {{ optional($doc->created_at)->format('d/m/Y H:i') ?? '' }}
                        </div>
                      </div>

                      @if (!empty($doc->path))
                        <a
                          href="{{ asset('storage/' . $doc->path) }}"
                          target="_blank"
                          class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                          Open
                        </a>
                      @endif
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>

          {{-- Document requests --}}
          <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
              <h3 class="text-lg font-semibold text-gray-900">Document requests</h3>
            </div>

            <div class="p-6">
              {{-- Create Document Request --}}
              <div class="mb-6 rounded-lg border border-gray-200 p-4">
                <form method="POST" action="{{ route('agent.documentRequests.store', $ticket) }}">
                  @csrf

                  <div class="grid grid-cols-1 gap-4">
                    <div>
                      <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Title</div>
                      <input
                        type="text"
                        name="title"
                        required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                      >
                    </div>

                    <div>
                      <div class="py-2 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Notes (optional)
                      </div>
                      <textarea
                        name="notes"
                        rows="3"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                      ></textarea>
                    </div>

                    <div class="flex justify-end">
                      <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                      >
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
                        <div class="mt-1 whitespace-pre-line text-sm text-gray-700">
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
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                          Uploaded files for this request
                        </div>

                        @if ($requestDocs->isEmpty())
                          <div class="mt-1 text-sm text-gray-600">
                            No file uploaded yet.
                          </div>
                        @else
                          <div class="mt-2 space-y-2">
                            @foreach ($requestDocs as $doc)
                              <div class="flex flex-col gap-2 rounded-lg border border-gray-200 p-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm font-semibold text-gray-900">
                                  {{ $doc->original_name ?? basename($doc->path ?? '') ?? 'Document' }}
                                </div>

                                @if (!empty($doc->path))
                                  <a
                                    href="{{ asset('storage/' . $doc->path) }}"
                                    target="_blank"
                                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                  >
                                    Open
                                  </a>
                                @endif
                              </div>
                            @endforeach
                          </div>
                        @endif
                      </div>
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
