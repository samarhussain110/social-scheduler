<x-app-layout>

    <div class="min-h-screen bg-slate-50">

        {{-- TOP HEADER --}}
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-6 lg:px-8">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Activity Logs
                    </p>

                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                        Activity History
                    </h1>
                </div>

            </div>
        </header>


        {{-- MAIN CONTENT --}}
        <main class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- FILTERS --}}
            <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4">
                <form action="{{ route('activity-logs.index') }}" method="GET" class="flex flex-wrap gap-4">
                    
                    {{-- Action Filter --}}
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Action</label>
                        <select name="action" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value="">All Actions</option>
                            @foreach ($actions as $action)
                                <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                    {{ $action }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date Range --}}
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-slate-700 mb-1">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" 
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-slate-700 mb-1">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" 
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" 
                                class="rounded-xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-indigo-700">
                            Filter
                        </button>
                        
                        <a href="{{ route('activity-logs.index') }}" 
                           class="ml-2 rounded-xl border border-slate-300 bg-white px-5 py-2 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            {{-- ACTIVITY LOGS LIST --}}
            @if ($activityLogs->count() > 0)
                <div class="space-y-4">

                    @foreach ($activityLogs as $log)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <div class="flex items-start justify-between">

                                <div class="flex-1">

                                    {{-- Action Badge --}}
                                    <div class="mb-3 flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            {{ $log->action }}
                                        </span>

                                        @if ($log->entity_type)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                {{ $log->entity_type }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Description --}}
                                    <p class="mb-3 text-sm text-slate-700">
                                        {{ $log->description }}
                                    </p>

                                    {{-- Time and IP --}}
                                    <div class="flex items-center gap-4 text-xs text-slate-500">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $log->created_at->format('M d, Y - g:i A') }}
                                        </div>

                                        @if ($log->ip_address)
                                            <div class="flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                </svg>
                                                {{ $log->ip_address }}
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                {{-- Actions --}}
                                <div class="ml-4 flex gap-2">

                                    <a href="{{ route('activity-logs.show', $log) }}" 
                                       class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    <form action="{{ route('activity-logs.destroy', $log) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="rounded-lg p-2 text-red-500 transition hover:bg-red-50 hover:text-red-700"
                                                onclick="return confirm('Are you sure you want to delete this activity log?')">
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
                    {{ $activityLogs->links() }}
                </div>

            @else
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                        <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-slate-900">
                        No activity logs yet
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Your activity history will appear here as you use the application.
                    </p>

                </div>
            @endif

        </main>

    </div>

</x-app-layout>