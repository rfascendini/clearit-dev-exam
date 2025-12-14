<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Notifications
                </h2>
                <p class="text-sm text-gray-500">
                    Your latest notifications
                </p>
            </div>

            @if ($notifications->whereNull('read_at')->count() > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2
                               text-sm font-semibold text-white shadow-sm hover:bg-blue-700
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

                @forelse ($notifications as $notification)
                    @php
                        $isUnread = is_null($notification->read_at);
                        $title = $notification->data['title'] ?? 'Notification';
                        $message = $notification->data['message']
                                   ?? $notification->data['body']
                                   ?? null;
                        $url = $notification->data['url'] ?? null;
                    @endphp

                    <div class="flex items-start gap-4 border-b border-gray-100 px-6 py-4
                                {{ $isUnread ? 'bg-blue-50/40' : 'bg-white' }}">

                        {{-- Unread indicator --}}
                        <span class="mt-2 h-2.5 w-2.5 flex-none rounded-full
                                     {{ $isUnread ? 'bg-blue-600' : 'bg-gray-300' }}">
                        </span>

                        <div class="flex-1">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $title }}
                                    </p>

                                    @if ($message)
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ $message }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex flex-col items-end gap-2">
                                    <span class="text-xs text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>

                                    @if ($isUnread)
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="text-xs font-semibold text-blue-600 hover:text-blue-700"
                                            >
                                                Mark as read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            @if ($url)
                                <div class="mt-2">
                                    <a
                                        href="{{ $url }}"
                                        class="text-sm font-semibold text-blue-600 hover:text-blue-700"
                                    >
                                        View details →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center">
                        <p class="text-sm text-gray-600">
                            You don’t have any notifications yet.
                        </p>
                    </div>
                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>
