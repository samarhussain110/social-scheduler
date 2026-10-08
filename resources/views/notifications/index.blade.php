<x-app-layout>

    <div class="min-h-screen bg-slate-50">

        {{-- TOP HEADER --}}
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-6 lg:px-8">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Notifications
                    </p>

                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                        Your Notifications
                    </h1>
                </div>

                @if (auth()->user()->notifications()->unread()->count() > 0)
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mark All as Read
                        </button>
                    </form>
                @endif

            </div>
        </header>


        {{-- MAIN CONTENT --}}
        <main class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- FILTER TABS --}}
            <div class="mb-6 flex gap-2 border-b border-slate-200">
                <a href="{{ route('notifications.index') }}" 
                   class="px-4 py-2 text-sm font-semibold text-indigo-600 border-b-2 border-indigo-600">
                    All Notifications
                </a>
                <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" 
                   class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900">
                    Unread ({{ auth()->user()->notifications()->unread()->count() }})
                </a>
            </div>

            {{-- NOTIFICATIONS LIST --}}
            @if ($notifications->count() > 0)
                <div class="space-y-4">

                    @foreach ($notifications as $notification)
                        <div class="rounded-2xl border {{ $notification->isRead() ? 'border-slate-200 bg-white' : 'border-indigo-200 bg-indigo-50' }} p-6 shadow-sm">

                            <div class="flex items-start justify-between">

                                <div class="flex-1">

                                    {{-- Type Badge --}}
                                    <div class="mb-3 flex items-center gap-2">
                                        @if ($notification->type === 'success')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Success
                                            </span>
                                        @elseif ($notification->type === 'error')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Error
                                            </span>
                                        @elseif ($notification->type === 'warning')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                Warning
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Info
                                            </span>
                                        @endif

                                        @if (!$notification->isRead())
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                                <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                                                New
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Title --}}
                                    <h3 class="mb-2 text-lg font-semibold text-slate-900">
                                        {{ $notification->title }}
                                    </h3>

                                    {{-- Message --}}
                                    <p class="mb-3 text-sm text-slate-700">
                                        {{ $notification->message }}
                                    </p>

                                    {{-- Time --}}
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>

                                </div>

                                {{-- Actions --}}
                                <div class="ml-4 flex gap-2">

                                    @if ($notification->link)
                                        <a href="{{ $notification->link }}" 
                                           class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    @endif

                                    <a href="{{ route('notifications.show', $notification) }}" 
                                       class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    @if ($notification->isRead())
                                        <form action="{{ route('notifications.mark-unread', $notification) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('notifications.mark-read', $notification) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="rounded-lg p-2 text-red-500 transition hover:bg-red-50 hover:text-red-700"
                                                onclick="return confirm('Are you sure you want to delete this notification?')">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

                {{-- PAGINATION --}}
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>

            @else
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                        <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-slate-900">
                        No notifications yet
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        You'll see notifications here when something important happens.
                    </p>

                </div>
            @endif

        </main>

    </div>

</x-app-layout>