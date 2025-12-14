<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            My Tickets
        </h2>
    </x-slot>

    <div class="py-10 mt-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Ticket List
                    </h3>

                    <a
                        href="{{ route('tickets.create') }}"
                        class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm
                               hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Create Ticket
                    </a>
                </div>

                @if ($tickets->isEmpty())
                    <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm font-medium text-yellow-800">
                        No tickets found.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                        ID
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                        Name
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($tickets as $ticket)
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

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            #{{ $ticket->id }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            {{ $ticket->name ?? '—' }}
                                        </td>

                                        <td class="px-4 py-3 text-sm">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $badge }}">
                                                {{ $label }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3 text-sm">
                                            <a
                                                href="{{ route('tickets.show', $ticket) }}"
                                                class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm
                                                       hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                            >
                                                View
                                            </a>
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
