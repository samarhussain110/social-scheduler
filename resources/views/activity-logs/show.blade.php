<x-app-layout>

    <div class="min-h-screen bg-slate-50">

        {{-- TOP HEADER --}}
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-6 lg:px-8">

                <div>
                    <a href="{{ route('activity-logs.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">
                        &larr; Back to Activity Logs
                    </a>

                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                        Activity Log Details
                    </h1>
                </div>

            </div>
        </header>


        {{-- MAIN CONTENT --}}
        <main class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">

            <div class="max-w-3xl">

                {{-- ACTIVITY LOG CARD --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">

                    {{-- Action Badge --}}
                    <div class="mb-4 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            {{ $activityLog->action }}
                        </span>

                        @if ($activityLog->entity_type)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                {{ $activityLog->entity_type }}
                            </span>
                        @endif
                    </div>

                    {{-- Description --}}
                    <h2 class="mb-6 text-2xl font-bold text-slate-900">
                        {{ $activityLog->description }}
                    </h2>

                    {{-- Entity Information --}}
                    @if ($activityLog->entity_type && $activityLog->entity_id)
                        <div class="mb-6">
                            <h3 class="mb-2 text-sm font-semibold text-slate-900">Related Entity</h3>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-sm text-slate-700">
                                    <span class="font-medium">Type:</span> {{ $activityLog->entity_type }}<br>
                                    <span class="font-medium">ID:</span> {{ $activityLog->entity_id }}
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Old Values --}}
                    @if ($activityLog->old_values)
                        <div class="mb-6">
                            <h3 class="mb-2 text-sm font-semibold text-slate-900">Previous Values</h3>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <pre class="text-xs text-slate-600">{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif

                    {{-- New Values --}}
                    @if ($activityLog->new_values)
                        <div class="mb-6">
                            <h3 class="mb-2 text-sm font-semibold text-slate-900">New Values</h3>
                            <div class="rounded-lg bg-slate-50 p-4">
                                <pre class="text-xs text-slate-600">{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif

                    {{-- Metadata --}}
                    <div class="space-y-2 text-sm text-slate-600">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Created: {{ $activityLog->created_at->format('M d, Y - g:i A') }}</span>
                        </div>

                        @if ($activityLog->ip_address)
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <span>IP Address: {{ $activityLog->ip_address }}</span>
                            </div>
                        @endif

                        @if ($activityLog->user_agent)
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="truncate">User Agent: {{ $activityLog->user_agent }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 flex gap-3">
                        <a href="{{ route('activity-logs.index') }}" 
                           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Activity Logs
                        </a>

                        <form action="{{ route('activity-logs.destroy', $activityLog) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 rounded-xl border border-red-300 bg-white px-5 py-3 text-sm font-semibold text-red-600 shadow-sm transition duration-200 hover:bg-red-50"
                                    onclick="return confirm('Are you sure you want to delete this activity log?')">
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