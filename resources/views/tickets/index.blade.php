<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            My Tickets
        </h2>
    </x-slot>

    <div class="py-10" style="margin-top: 50px">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Ticket List
                    </h3>

                    <a href="{{ route('tickets.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 font-medium rounded-md hover:bg-indigo-700" style="background-color: blue; color: white;">
                        Create Ticket
                    </a>
                </div>

                @if ($tickets->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded">
                        No tickets found.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-600 uppercase" style="text-align:left">
                                        ID
                                    </th>
                                    <th class="px-4 py-3 font-semibold text-gray-600 uppercase" style="text-align:left">
                                        Name
                                    </th>
                                    <th class="px-4 py-3 font-semibold text-gray-600 uppercase" style="text-align:left">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 font-semibold text-gray-600 uppercase" style="text-align:left">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($tickets as $ticket)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            #{{ $ticket->id }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            {{ $ticket->name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 font-medium
                                                @if ($ticket->status === 'new') bg-blue-100 text-blue-800
                                                @elseif ($ticket->status === 'in_progress') bg-yellow-100 text-yellow-800
                                                @elseif ($ticket->status === 'completed') bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <a href="{{ route('tickets.show', $ticket) }}"
                                               class="inline-flex items-left rounded-lg px-3 py-2 text-xs font-semibold" style="background-color: blue; color: #FFFFFF;">
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
