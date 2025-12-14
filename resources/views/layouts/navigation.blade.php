<nav x-data="{ open: false, notifOpen: false }" class="border-b border-gray-100 bg-white">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(auth()->user()->role === 'user')
                        <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')">
                            {{ __('My Tickets') }}
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->role === 'agent')
                        <x-nav-link :href="route('agent.tickets.index')" :active="request()->routeIs('agent.tickets.*')">
                            {{ __('Tickets') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                {{-- Notifications (CLICK dropdown) --}}
                <div class="relative me-2">
                    <button
                        type="button"
                        @click="notifOpen = !notifOpen"
                        class="relative inline-flex items-center justify-center rounded-lg px-3 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30"
                        aria-label="Notifications"
                    >
                        {{-- Bell icon --}}
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10 2a6 6 0 00-6 6v2.586L3.293 12.293A1 1 0 004 14h12a1 1 0 00.707-1.707L16 10.586V8a6 6 0 00-6-6z"/>
                            <path d="M9 17a1 1 0 102 0H9z"/>
                        </svg>

                        @if (($navbarUnreadCount ?? 0) > 0)
                            <span class="absolute -right-1 -top-1 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-600 px-1 text-xs font-bold text-white">
                                {{ $navbarUnreadCount }}
                            </span>
                        @endif
                    </button>

                    <div
                        x-show="notifOpen"
                        x-transition.opacity
                        @click.outside="notifOpen = false"
                        @keydown.escape.window="notifOpen = false"
                        class="absolute right-0 top-full z-50 mt-2 w-96 max-w-[calc(100vw-2rem)] rounded-xl border border-gray-200 bg-white shadow-lg"
                        style="display: none;"
                    >
                        <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                            <div class="text-sm font-semibold text-gray-900">Notifications</div>

                            <div class="flex items-center gap-2">
                                @if (($navbarUnreadCount ?? 0) > 0)
                                    <form method="POST" action="{{ route('notifications.readAll') }}">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                            Mark all read
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('notifications.index') }}" class="text-xs font-semibold text-gray-600 hover:text-gray-800">
                                    View all
                                </a>
                            </div>
                        </div>

                        <div class="max-h-80 overflow-auto">
                            @forelse(($navbarNotifications ?? collect()) as $n)
                                @php
                                    $isUnread = is_null($n->read_at);
                                    $title = $n->data['title'] ?? 'Notification';
                                    $message = $n->data['message'] ?? ($n->data['body'] ?? null);
                                    $url = $n->data['url'] ?? route('notifications.index');
                                @endphp

                                <div class="border-b border-gray-100 last:border-b-0">
                                    <div class="flex gap-3 px-4 py-3 hover:bg-gray-50">
                                        <span class="mt-1 inline-flex h-2.5 w-2.5 flex-none rounded-full {{ $isUnread ? 'bg-blue-600' : 'bg-gray-300' }}"></span>

                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-start justify-between gap-2">
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-semibold {{ $isUnread ? 'text-gray-900' : 'text-gray-700' }}">
                                                        {{ $title }}
                                                    </p>

                                                    @if ($message)
                                                        <p class="mt-1 line-clamp-2 text-xs text-gray-600">
                                                            {{ $message }}
                                                        </p>
                                                    @endif
                                                </div>

                                                <span class="flex-none text-xs text-gray-500">
                                                    {{ $n->created_at->diffForHumans() }}
                                                </span>
                                            </div>

                                            <div class="mt-2 flex items-center gap-2">
                                                <a href="{{ $url }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                                    Open →
                                                </a>

                                                @if ($isUnread)
                                                    <form method="POST" action="{{ route('notifications.read', $n->id) }}">
                                                        @csrf
                                                        <button type="submit" class="text-xs font-semibold text-gray-600 hover:text-gray-800">
                                                            Mark read
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-6 text-sm text-gray-600">
                                    No notifications yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                        >
                            <div>{{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role) }})</div>

                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(auth()->user()->role === 'user')
                <x-responsive-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')">
                    {{ __('My Tickets') }}
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->role === 'agent')
                <x-responsive-nav-link :href="route('agent.tickets.index')" :active="request()->routeIs('agent.tickets.*')">
                    {{ __('Tickets') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                {{ __('Notifications') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="border-t border-gray-200 pb-1 pt-4">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
