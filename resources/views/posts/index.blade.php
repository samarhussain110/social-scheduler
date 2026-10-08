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
                        Scheduled Posts
                    </h1>
                </div>

                <a
                    href="{{ route('posts.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>

                    Create Post
                </a>

            </div>
        </header>


        {{-- MAIN CONTENT --}}
        <main class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            {{-- FILTER TABS --}}
            <div class="mb-6 flex gap-2 border-b border-slate-200">
                <a href="{{ route('posts.index') }}" 
                   class="px-4 py-2 text-sm font-semibold text-indigo-600 border-b-2 border-indigo-600">
                    All Posts
                </a>
            </div>

            {{-- POSTS LIST --}}
            @if ($posts->count() > 0)
                <div class="space-y-4">

                    @foreach ($posts as $post)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <div class="flex items-start justify-between">

                                <div class="flex-1">

                                    {{-- Platform Badge --}}
                                    <div class="mb-3 flex items-center gap-2">
                                        @if ($post->platform === 'facebook')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073c0 6.02 4.388 11.003 10.125 11.926v-8.437H7.078v-3.49h3.047V9.413c0-3.02 1.79-4.688 4.532-4.688 1.313 0 2.686.236 2.686.236v2.973h-1.515c-1.492 0-1.953.93-1.953 1.885v2.253h3.328l-.532 3.49h-2.796V24C19.612 23.076 24 18.093 24 12.073z"/>
                                                </svg>
                                                Facebook
                                            </span>
                                        @elseif ($post->platform === 'instagram')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-pink-50 px-3 py-1 text-xs font-semibold text-pink-700">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2"/>
                                                    <circle cx="12" cy="12" r="4" stroke-width="2"/>
                                                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>
                                                </svg>
                                                Instagram
                                            </span>
                                        @elseif ($post->platform === 'linkedin')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">
                                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.605 0 4.27 2.373 4.27 5.467v6.274zM5.337 7.433a2.062 2.062 0 110-4.124 2.062 2.062 0 010 4.124zM7.119 20.452H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 .774 22.225 0z"/>
                                                </svg>
                                                LinkedIn
                                            </span>
                                        @endif

                                        {{-- Status Badge --}}
                                        @if ($post->status === 'scheduled')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-violet-50 px-3 py-1 text-xs font-semibold text-violet-700">
                                                <span class="h-2 w-2 rounded-full bg-violet-500"></span>
                                                Scheduled
                                            </span>
                                        @elseif ($post->status === 'published')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                                Published
                                            </span>
                                        @elseif ($post->status === 'failed')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                                Failed
                                            </span>
                                        @elseif ($post->status === 'cancelled')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                                Cancelled
                                            </span>
                                        @elseif ($post->status === 'pending')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                                Pending
                                            </span>
                                        @elseif ($post->status === 'publishing')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                                <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                Publishing
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Content --}}
                                    <p class="mb-3 text-sm text-slate-700 line-clamp-2">
                                        {{ Str::limit($post->content, 200) }}
                                    </p>

                                    {{-- Media Preview --}}
                                    @if ($post->media->count() > 0)
                                        <div class="mb-3 flex gap-2">
                                            @foreach ($post->media->take(3) as $media)
                                                @if ($media->media_type === 'image')
                                                    <img src="{{ $media->full_url }}" 
                                                         alt="{{ $media->file_name }}" 
                                                         class="h-16 w-16 rounded-lg object-cover">
                                                @else
                                                    <div class="flex h-16 w-16 items-center justify-center rounded-lg bg-slate-100">
                                                        <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if ($post->media->count() > 3)
                                                <div class="flex h-16 w-16 items-center justify-center rounded-lg bg-slate-100 text-xs font-medium text-slate-600">
                                                    +{{ $post->media->count() - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Scheduled Time --}}
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $post->scheduled_at->setTimezone($post->timezone)->format('M d, Y - g:i A') }}
                                        <span class="text-slate-400">({{ $post->timezone }})</span>
                                    </div>

                                </div>

                                {{-- Actions --}}
                                <div class="ml-4 flex gap-2">

                                    <a href="{{ route('posts.show', $post) }}" 
                                       class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    @if (!in_array($post->status, ['published', 'publishing', 'cancelled']))
                                        <a href="{{ route('posts.edit', $post) }}" 
                                           class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        @if (!in_array($post->status, ['failed']))
                                            <form action="{{ route('posts.cancel', $post) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                                                        onclick="return confirm('Are you sure you want to cancel this post?')">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    @if (!in_array($post->status, ['published', 'publishing']))
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="rounded-lg p-2 text-red-500 transition hover:bg-red-50 hover:text-red-700"
                                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

                {{-- PAGINATION --}}
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>

            @else
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                        <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-slate-900">
                        No posts yet
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Get started by creating your first scheduled post.
                    </p>

                    <a href="{{ route('posts.create') }}" 
                       class="mt-6 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-indigo-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Post
                    </a>

                </div>
            @endif

        </main>

    </div>

</x-app-layout>
