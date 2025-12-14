<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="font-semibold text-left text-xl text-gray-800 leading-tight">
          Agent · Tickets
        </h2>
        <p class="text-sm text-gray-500">All tickets created by users</p>
      </div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      @if (session('success'))
        <div class="mb-4 rounded-lg border px-4 py-6" style="color: white; background-color: green; border-color: green;">
          {{ session('success') }}
        </div>
      @endif

      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
          <div class="text-sm text-gray-600">
            Showing <span class="font-semibold text-left text-gray-900">{{ $tickets->count() }}</span> tickets
          </div>
        </div>

        @if ($tickets->isEmpty())
          <div class="p-6">
            <p class="text-gray-600">No tickets found.</p>
          </div>
        @else
          <div class="">
            <table class="table-auto w-full border-collapse">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-4 font-semibold uppercase text-gray-600" style="text-align:left">
                    ID</th>
                  <th class="px-6 py-4 font-semibold uppercase text-gray-600" style="text-align:left">
                    Title</th>
                  <th class="px-6 py-4 font-semibold uppercase text-gray-600" style="text-align:left">
                    User Name</th>
                  <th class="px-6 py-4 font-semibold uppercase text-gray-600" style="text-align:left">
                    User Email</th>
                  <th class="px-6 py-4 font-semibold uppercase text-gray-600" style="text-align:left">
                    Status</th>
                  <th class="px-6 py-4 font-semibold uppercase text-gray-600" style="text-align:left">
                    Created</th>
                  <th class="px-6 py-4 font-semibold uppercase text-gray-600" style="text-align:left">
                    Actions</th>
                </tr>
              </thead>

              <tbody class="bg-white divide-y divide-gray-100">
                @foreach ($tickets as $ticket)
                  <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">
                      #{{ $ticket->id }}
                    </td>

                    <td class="px-6 py-4">
                      <div class="text-sm font-semibold text-left text-gray-900">
                        {{ $ticket->name ?? $ticket->title ?? '—' }}
                      </div>
                      @if (!empty($ticket->description))
                        <div class="text-xs text-gray-500 line-clamp-1">
                          {{ $ticket->description }}
                        </div>
                      @endif
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      <div class="font-semibold text-left text-gray-900">
                        {{ $ticket->user->name ?? '—' }}
                      </div>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      <div class="font-semibold text-left text-gray-900">
                        {{ $ticket->user->email ?? '—' }}
                      </div>

                    <td class="px-6 py-4">
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
                      @endphp

                      <span class="inline-flex items-left rounded-full px-2.5 py-1 text-xs font-semibold text-left {{ $badge }}">
                        {{ $label }}
                      </span>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ optional($ticket->created_at)->format('d/m/Y H:i') ?? '—' }}
                    </td>

                    <td class="px-6 py-4">
                      <div class="flex justify-start gap-2">
                        <a href="{{ route('agent.tickets.show', $ticket) }}"
                          class="inline-flex items-left rounded-lg px-3 py-2 text-xs font-semibold" style="background-color: blue; color: #FFFFFF;">
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