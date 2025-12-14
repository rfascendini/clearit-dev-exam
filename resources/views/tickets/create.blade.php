<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Create Ticket
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <form method="POST" action="{{ route('tickets.store') }}" class="space-y-6 p-6">
                    @csrf

                    {{-- Ticket name --}}
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Ticket Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            required
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        >
                    </div>

                    {{-- Ticket type --}}
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Ticket Type
                        </label>
                        <select
                            name="type"
                            required
                            class="mt-1 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        >
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Transport mode --}}
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Transport Mode
                        </label>
                        <select
                            name="transport_mode"
                            required
                            class="mt-1 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        >
                            @foreach ($transportModes as $mode)
                                <option value="{{ $mode }}">{{ ucfirst($mode) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Product --}}
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Product
                        </label>
                        <input
                            type="text"
                            name="product"
                            required
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        >
                    </div>

                    {{-- Country origin --}}
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Country of Origin
                        </label>
                        <input
                            type="text"
                            name="country_origin"
                            required
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        >
                    </div>

                    {{-- Country destination --}}
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Country of Destination
                        </label>
                        <input
                            type="text"
                            name="country_destination"
                            required
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 shadow-sm
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        >
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a
                            href="{{ route('tickets.index') }}"
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2
                                   text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50
                                   focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2
                                   text-sm font-semibold text-white shadow-sm hover:bg-green-700
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        >
                            Create Ticket
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
