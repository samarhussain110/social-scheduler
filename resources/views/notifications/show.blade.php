<x-app-layout>

    <div class="min-h-screen bg-slate-50">

        {{-- TOP HEADER --}}
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-6 lg:px-8">

                <div>
                    <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">
                        &larr; Back to Notifications
                    </a>

                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                        Notification Details
                    </h1>
                </div>

            </div>
        </header>


        {{-- MAIN CONTENT --}}
        <main class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">

            <div class="max-w-3xl">

                {{-- NOTIFICATION CARD --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">

                    {{-- Type Badge --}}
                    <div class="mb-4 flex items-center gap-2">
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

                        @if ($notification->isRead())
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                Read
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                                Unread
                            </span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h2 class="mb-4 text-2xl font-bold text-slate-900">
                        {{ $notification->title }}
                    </h2>

                    {{-- Message --}}
                    <div class="mb-6 rounded-lg bg-slate-50 p-4">
                        <p class="text-slate-700">
                            {{ $notification->message }}
                        </p>
                    </div>

                    {{-- Additional Data --}}
                    @if ($notification->data)
                        <div class="mb-6">
                            <h3 class="mb-2 text-sm font-semibold text-slate-900">Additional Information</h3>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <pre class="text-xs text-slate-600">{{ json_encode($notification->data, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif

                    {{-- Metadata --}}
                    <div class="space-y-2 text-sm text-slate-600">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Created: {{ $notification->created_at->format('M d, Y - g:i A') }}</span>
                        </div>

                        @if ($notification->read_at)
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Read: {{ $notification->read_at->format('M d, Y - g:i A') }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 flex gap-3">
                        @if ($notification->link)
                            <a href="{{ $notification->link }}" 
                               class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-indigo-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                View Related Item
                            </a>
                        @endif

                        @if ($notification->isRead())
                            <form action="{{ route('notifications.mark-unread', $notification) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Mark as Unread
                                </button>
                            </form>
                        @else
                            <form action="{{ route('notifications.mark-read', $notification) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Mark as Read
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 rounded-xl border border-red-300 bg-white px-5 py-3 text-sm font-semibold text-red-600 shadow-sm transition duration-200 hover:bg-red-50"
                                    onclick="return confirm('Are you sure you want to delete this notification?')">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </main>

    </div>

</x-app-layout>