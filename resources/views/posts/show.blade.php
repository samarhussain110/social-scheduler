<x-app-layout>

    <div class="min-h-screen bg-slate-50">

        {{-- TOP HEADER --}}
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-6 lg:px-8">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Posts
                    </p>

                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                        Post Details
                    </h1>
                </div>

                <div class="flex gap-2">

                    @if (!in_array($post->status, ['published', 'publishing', 'cancelled']))
                        <a
                            href="{{ route('posts.edit', $post) }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>

                            Edit
                        </a>
                    @endif

                    <a
                        href="{{ route('posts.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50"
                    >
                        Back to Posts
                    </a>

                </div>

            </div>
        </header>


        {{-- MAIN CONTENT --}}
        <main class="mx-auto max-w-4xl px-5 py-8 sm:px-6 lg:px-8">

            <div class="space-y-6">

                {{-- POST STATUS CARD --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div class="flex items-center gap-4">

                            {{-- Platform Icon --}}
                            @if ($post->platform === 'facebook')
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50">
                                    <svg class="h-7 w-7 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073c0 6.02 4.388 11.003 10.125 11.926v-8.437H7.078v-3.49h3.047V9.413c0-3.02 1.79-4.688 4.532-4.688 1.313 0 2.686.236 2.686.236v2.973h-1.515c-1.492 0-1.953.93-1.953 1.885v2.253h3.328l-.532 3.49h-2.796V24C19.612 23.076 24 18.093 24 12.073z"/>
                                    </svg>
                                </div>
                            @elseif ($post->platform === 'instagram')
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-50">
                                    <svg class="h-7 w-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2"/>
                                        <circle cx="12" cy="12" r="4" stroke-width="2"/>
                                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>
                                    </svg>
                                </div>
                            @elseif ($post->platform === 'linkedin')
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-50">
                                    <svg class="h-7 w-7 text-sky-700" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.605 0 4.27 2.373 4.27 5.467v6.274zM5.337 7.433a2.062 2.062 0 110-4.124 2.062 2.062 0 010 4.124zM7.119 20.452H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 .774 22.225 0z"/>
                                    </svg>
                                </div>
                            @endif

                            <div>
                                <h2 class="text-xl font-bold text-slate-900 capitalize">
                                    {{ $post->platform }} Post
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $post->socialAccount->account_name }}
                                </p>
                            </div>

                        </div>

                        {{-- Status Badge --}}
                        @if ($post->status === 'scheduled')
                            <span class="inline-flex items-center gap-2 rounded-full bg-violet-50 px-4 py-2 text-sm font-semibold text-violet-700">
                                <span class="h-2 w-2 rounded-full bg-violet-500"></span>
                                Scheduled
                            </span>
                        @elseif ($post->status === 'published')
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Published
                            </span>
                        @elseif ($post->status === 'failed')
                            <span class="inline-flex items-center gap-2 rounded-full bg-red-50 px-4 py-2 text-sm font-semibold text-red-700">
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                Failed
                            </span>
                        @elseif ($post->status === 'cancelled')
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600">
                                <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                Cancelled
                            </span>
                        @elseif ($post->status === 'publishing')
                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700">
                                <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                Publishing
                            </span>
                        @elseif ($post->status === 'pending')
                            <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                Pending
                            </span>
                        @endif

                    </div>

                </div>

                {{-- POST CONTENT --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h3 class="mb-4 text-lg font-semibold text-slate-900">
                        Content
                    </h3>

                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="whitespace-pre-wrap text-sm text-slate-700">
                            {{ $post->content }}
                        </p>
                    </div>

                </div>

                {{-- MEDIA --}}
                @if ($post->media->count() > 0)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h3 class="mb-4 text-lg font-semibold text-slate-900">
                            Media ({{ $post->media->count() }})
                        </h3>

                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">

                            @foreach ($post->media as $media)
                                <div class="relative aspect-square rounded-xl overflow-hidden bg-slate-100">

                                    @if ($media->media_type === 'image')
                                        <img src="{{ $media->full_url }}" 
                                             alt="{{ $media->file_name }}" 
                                             class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="absolute bottom-0 left-0 right-0 rounded-b-xl bg-black/60 p-2">
                                        <p class="truncate text-xs text-white">
                                            {{ $media->file_name }}
                                        </p>
                                        @if ($media->caption)
                                            <p class="mt-1 truncate text-xs text-white/80">
                                                {{ $media->caption }}
                                            </p>
                                        @endif
                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>
                @endif

                {{-- SCHEDULE DETAILS --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h3 class="mb-4 text-lg font-semibold text-slate-900">
                        Schedule Details
                    </h3>

                    <div class="grid gap-4 sm:grid-cols-2">

                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Scheduled For
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $post->scheduled_at->setTimezone($post->timezone)->format('F d, Y - g:i A') }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                {{ $post->timezone }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Created At
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $post->created_at->format('F d, Y - g:i A') }}
                            </p>
                        </div>

                        @if ($post->published_at)
                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Published At
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $post->published_at->format('F d, Y - g:i A') }}
                                </p>
                            </div>
                        @endif

                        @if ($post->platform_post_id)
                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Platform Post ID
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $post->platform_post_id }}
                                </p>
                            </div>
                        @endif

                    </div>

                </div>

                {{-- ERROR MESSAGE (if failed) --}}
                @if ($post->error_message)
                    <div class="rounded-2xl border border-red-200 bg-red-50 p-6 shadow-sm">

                        <h3 class="mb-2 text-lg font-semibold text-red-900">
                            Error Details
                        </h3>

                        <p class="text-sm text-red-700">
                            {{ $post->error_message }}
                        </p>

                        @if ($post->retry_count > 0)
                            <p class="mt-2 text-xs text-red-600">
                                Retry attempts: {{ $post->retry_count }} / {{ $post->max_retries }}
                            </p>
                        @endif

                    </div>
                @endif

                {{-- API RESPONSE (if published) --}}
                @if ($post->api_response && $post->status === 'published')
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h3 class="mb-4 text-lg font-semibold text-slate-900">
                            API Response
                        </h3>

                        <div class="rounded-xl bg-slate-900 p-4">
                            <pre class="text-xs text-emerald-400 overflow-x-auto">{{ json_encode($post->api_response, JSON_PRETTY_PRINT) }}</pre>
                        </div>

                    </div>
                @endif

                {{-- ACTIONS --}}
                @if (!in_array($post->status, ['published', 'publishing', 'cancelled']))
                    <div class="flex justify-end gap-3">

                        @if (!in_array($post->status, ['failed']))
                            <form action="{{ route('posts.cancel', $post) }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50"
                                    onclick="return confirm('Are you sure you want to cancel this post?')"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>

                                    Cancel Post
                                </button>
                            </form>
                        @endif

                        @if (!in_array($post->status, ['published', 'publishing']))
                            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl border border-red-300 bg-red-50 px-6 py-3 text-sm font-semibold text-red-700 shadow-sm transition duration-200 hover:bg-red-100"
                                    onclick="return confirm('Are you sure you want to delete this post? This action cannot be undone.')"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>

                                    Delete Post
                                </button>
                            </form>
                        @endif

                    </div>
                @endif

            </div>

        </main>

    </div>

</x-app-layout>
