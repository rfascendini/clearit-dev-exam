<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Ticket #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- Ticket info --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><span class="text-sm font-semibold text-gray-500">Name</span><div class="text-sm text-gray-900">{{ $ticket->name }}</div></div>
                    <div><span class="text-sm font-semibold text-gray-500">Status</span><div class="text-sm text-gray-900">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</div></div>
                    <div><span class="text-sm font-semibold text-gray-500">Type</span><div class="text-sm text-gray-900">{{ $ticket->type }}</div></div>
                    <div><span class="text-sm font-semibold text-gray-500">Transport</span><div class="text-sm text-gray-900">{{ $ticket->transport_mode }}</div></div>
                    <div><span class="text-sm font-semibold text-gray-500">Product</span><div class="text-sm text-gray-900">{{ $ticket->product }}</div></div>
                    <div><span class="text-sm font-semibold text-gray-500">Origin</span><div class="text-sm text-gray-900">{{ $ticket->country_origin }}</div></div>
                    <div class="sm:col-span-2"><span class="text-sm font-semibold text-gray-500">Destination</span><div class="text-sm text-gray-900">{{ $ticket->country_destination }}</div></div>
                </div>
            </div>

            {{-- Upload document --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Upload a document</h3>

                <form method="POST" action="{{ route('tickets.documents.store', $ticket) }}" enctype="multipart/form-data" class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    @csrf
                    <input
                        type="file"
                        name="document"
                        required
                        class="w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0
                               file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold
                               hover:file:bg-gray-200"
                    >
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2
                               text-sm font-semibold text-white shadow-sm hover:bg-blue-700
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Upload
                    </button>
                </form>
            </div>

            {{-- Documents list --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Documents</h3>

                @if ($ticket->documents->isEmpty())
                    <p class="text-sm text-gray-600">No documents uploaded.</p>
                @else
                    <ul class="space-y-3">
                        @foreach ($ticket->documents as $doc)
                            <li class="flex items-center justify-between rounded-lg border border-gray-200 p-4">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $doc->original_name ?? ('Document #' . $doc->id) }}
                                </span>

                                @if (!empty($doc->path))
                                    <a
                                        href="{{ asset('storage/' . $doc->path) }}"
                                        target="_blank"
                                        class="inline-flex items-center rounded-lg bg-blue-600 px-3 py-2
                                               text-xs font-semibold text-white shadow-sm hover:bg-blue-700
                                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    >
                                        View
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Document requests --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Document Requests</h3>

                @if ($ticket->documentRequests->isEmpty())
                    <p class="text-sm text-gray-600">No document requests.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($ticket->documentRequests as $req)
                            <div class="rounded-lg border border-gray-200 p-4">
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $req->title ?? ('Request #' . $req->id) }}
                                </div>

                                @if (!empty($req->notes))
                                    <div class="mt-1 text-sm text-gray-700">
                                        <span class="font-semibold text-gray-500">Notes:</span> {{ $req->notes }}
                                    </div>
                                @endif

                                @if (!empty($req->status))
                                    <div class="mt-1 text-sm text-gray-700">
                                        <span class="font-semibold text-gray-500">Status:</span> {{ $req->status }}
                                    </div>
                                @endif

                                <form
                                    method="POST"
                                    action="{{ route('documentRequests.upload', $req) }}"
                                    enctype="multipart/form-data"
                                    class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center"
                                >
                                    @csrf
                                    <input
                                        type="file"
                                        name="document"
                                        required
                                        class="w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0
                                               file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold
                                               hover:file:bg-gray-200"
                                    >
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2
                                               text-sm font-semibold text-white shadow-sm hover:bg-green-700
                                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                    >
                                        Upload for this request
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Back --}}
            <div class="flex justify-end">
                <a
                    href="{{ route('tickets.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2
                           text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50
                           focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                >
                    Back to Tickets
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
