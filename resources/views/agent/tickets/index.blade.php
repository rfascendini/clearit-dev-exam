<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Agent · Tickets
        </h2>
        <p class="text-sm text-gray-500">All tickets created by users</p>
      </div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
          {{ session('success') }}
        </div>
      @endif

      <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
          <div class="text-sm text-gray-600">
            Showing <span class="font-semibold text-gray-900">{{ $tickets->count() }}</span> tickets
          </div>
        </div>

        @if ($tickets->isEmpty())
          <div class="p-6">
            <p class="text-gray-600">No tickets found.</p>
          </div>
        @else
          <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">ID</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Title</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">User Name</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">User Email</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Status</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Created</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Actions</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-100 bg-white">
                @foreach ($tickets as $ticket)
                  <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">
                      #{{ $ticket->id }}
                    </td>

                    <td class="px-6 py-4">
                      <div class="text-sm font-semibold text-gray-900">
                        {{ $ticket->name ?? $ticket->title ?? '—' }}
                      </div>

                      @if (!empty($ticket->description))
                        <div class="mt-1 line-clamp-1 text-xs text-gray-500">
                          {{ $ticket->description }}
                        </div>
                      @endif
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      <div class="font-semibold text-gray-900">
                        {{ $ticket->user->name ?? '—' }}
                      </div>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      <div class="font-semibold text-gray-900">
                        {{ $ticket->user->email ?? '—' }}
                      </div>
                    </td>

                    <td class="px-6 py-4">
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
                      @endphp

                      <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $badge }}">
                        {{ $label }}
                      </span>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ optional($ticket->created_at)->format('d/m/Y H:i') ?? '—' }}
                    </td>

                    <td class="px-6 py-4">
                      <div class="flex items-center justify-start gap-2">
                        <a
                          href="{{ route('agent.tickets.show', $ticket) }}"
                          class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                          View
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>

    </div>
  </div>
</x-app-layout>
