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
                        Create New Post
                    </h1>
                </div>

                <a
                    href="{{ route('posts.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>

                    Cancel
                </a>

            </div>
        </header>


        {{-- MAIN CONTENT --}}
        <main class="mx-auto max-w-4xl px-5 py-8 sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @error('platform')
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                    {{ $message }}
                </div>
            @enderror

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">

                    {{-- PLATFORM SELECTION --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h3 class="mb-4 text-lg font-semibold text-slate-900">
                            Select Platform
                        </h3>

                        @if ($socialAccounts->count() > 0)
                            <div class="grid gap-4 sm:grid-cols-3">

                                @foreach (['facebook', 'instagram', 'linkedin'] as $platform)
                                    @if ($socialAccounts->has($platform))
                                        <label class="relative cursor-pointer">

                                            <input type="radio" 
                                                   name="platform" 
                                                   value="{{ $platform }}" 
                                                   class="peer sr-only"
                                                   required
                                                   @if($loop->first) checked @endif>

                                            <div class="rounded-xl border-2 border-slate-200 p-4 transition peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:border-slate-300">

                                                <div class="flex items-center gap-3">

                                                    @if ($platform === 'facebook')
                                                        <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073c0 6.02 4.388 11.003 10.125 11.926v-8.437H7.078v-3.49h3.047V9.413c0-3.02 1.79-4.688 4.532-4.688 1.313 0 2.686.236 2.686.236v2.973h-1.515c-1.492 0-1.953.93-1.953 1.885v2.253h3.328l-.532 3.49h-2.796V24C19.612 23.076 24 18.093 24 12.073z"/>
                                                        </svg>
                                                    @elseif ($platform === 'instagram')
                                                        <svg class="h-6 w-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2"/>
                                                            <circle cx="12" cy="12" r="4" stroke-width="2"/>
                                                            <circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>
                                                        </svg>
                                                    @elseif ($platform === 'linkedin')
                                                        <svg class="h-6 w-6 text-sky-700" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.605 0 4.27 2.373 4.27 5.467v6.274zM5.337 7.433a2.062 2.062 0 110-4.124 2.062 2.062 0 010 4.124zM7.119 20.452H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 .774 22.225 0z"/>
                                                        </svg>
                                                    @endif

                                                    <div>
                                                        <p class="font-semibold text-slate-900 capitalize">
                                                            {{ $platform }}
                                                        </p>
                                                        <p class="text-xs text-slate-500">
                                                            {{ $socialAccounts[$platform]->first()->account_name }}
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>

                                        </label>
                                    @endif
                                @endforeach

                            </div>

                            {{-- Hidden social account ID will be set via JS --}}
                            <input type="hidden" name="social_account_id" id="social_account_id">

                        @else
                            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                                <p class="font-semibold">No connected accounts</p>
                                <p class="mt-1">Please connect a social account first.</p>
                                <a href="{{ route('accounts.index') }}" class="mt-2 inline-block font-semibold text-amber-700 underline">
                                    Connect Account →
                                </a>
                            </div>
                        @endif

                    </div>

                    {{-- POST CONTENT --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h3 class="mb-4 text-lg font-semibold text-slate-900">
                            Post Content
                        </h3>

                        <div>
                            <label for="content" class="mb-2 block text-sm font-medium text-slate-700">
                                Text Content
                            </label>

                            <textarea
                                name="content"
                                id="content"
                                rows="5"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                placeholder="What would you like to share?"
                                required
                                maxlength="5000"
                            >{{ old('content') }}</textarea>

                            <div class="mt-2 flex justify-between text-xs text-slate-500">
                                <span>Supports emojis and hashtags</span>
                                <span id="char-count">0 / 5000</span>
                            </div>

                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- MEDIA UPLOAD --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h3 class="mb-4 text-lg font-semibold text-slate-900">
                            Media (Optional)
                        </h3>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Upload Images or Videos
                            </label>

                            <div class="rounded-xl border-2 border-dashed border-slate-300 p-8 text-center transition hover:border-slate-400 hover:bg-slate-50">

                                <input
                                    type="file"
                                    name="media[]"
                                    id="media"
                                    multiple
                                    accept="image/*,video/*"
                                    class="hidden"
                                >

                                <label for="media" class="cursor-pointer">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                        <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>

                                    <p class="mt-4 text-sm font-medium text-slate-900">
                                        Click to upload or drag and drop
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        PNG, JPG, GIF, MP4 up to 10MB each
                                    </p>

                                </label>

                            </div>

                            {{-- Media Preview --}}
                            <div id="media-preview" class="mt-4 grid grid-cols-4 gap-3"></div>

                            @error('media')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- SCHEDULE --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h3 class="mb-4 text-lg font-semibold text-slate-900">
                            Schedule
                        </h3>

                        <div class="grid gap-4 sm:grid-cols-2">

                            <div>
                                <label for="scheduled_date" class="mb-2 block text-sm font-medium text-slate-700">
                                    Date & Time
                                </label>

                                <input
                                    type="datetime-local"
                                    name="scheduled_date"
                                    id="scheduled_date"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                    required
                                    value="{{ old('scheduled_date') }}"
                                >

                                @error('scheduled_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="timezone" class="mb-2 block text-sm font-medium text-slate-700">
                                    Timezone
                                </label>

                                <select
                                    name="timezone"
                                    id="timezone"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                    required
                                >
                                    <option value="UTC">UTC</option>
                                    <option value="America/New_York">Eastern Time (ET)</option>
                                    <option value="America/Chicago">Central Time (CT)</option>
                                    <option value="America/Denver">Mountain Time (MT)</option>
                                    <option value="America/Los_Angeles">Pacific Time (PT)</option>
                                    <option value="Asia/Karachi">Pakistan (PKT)</option>
                                    <option value="Asia/Dubai">Dubai (GST)</option>
                                    <option value="Europe/London">London (GMT)</option>
                                    <option value="Europe/Paris">Paris (CET)</option>
                                    <option value="Asia/Tokyo">Tokyo (JST)</option>
                                    <option value="Australia/Sydney">Sydney (AEST)</option>
                                </select>

                                @error('timezone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>

                    {{-- SUBMIT --}}
                    <div class="flex justify-end gap-3">

                        <a
                            href="{{ route('posts.index') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-indigo-700 hover:shadow-md"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>

                            Schedule Post
                        </button>

                    </div>

                </div>

            </form>

        </main>

    </div>

    <script>
        // Character counter
        const content = document.getElementById('content');
        const charCount = document.getElementById('char-count');

        content.addEventListener('input', function() {
            charCount.textContent = this.value.length + ' / 5000';
        });

        // Initialize char count
        charCount.textContent = content.value.length + ' / 5000';

        // Set social account ID based on selected platform
        const platformInputs = document.querySelectorAll('input[name="platform"]');
        const socialAccountIdInput = document.getElementById('social_account_id');

        const socialAccounts = @json($socialAccounts);

        platformInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (socialAccounts[this.value]) {
                    socialAccountIdInput.value = socialAccounts[this.value][0].id;
                }
            });

            // Set initial value
            if (input.checked && socialAccounts[input.value]) {
                socialAccountIdInput.value = socialAccounts[input.value][0].id;
            }
        });

        // Media preview
        const mediaInput = document.getElementById('media');
        const mediaPreview = document.getElementById('media-preview');

        mediaInput.addEventListener('change', function(e) {
            mediaPreview.innerHTML = '';

            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-square rounded-lg overflow-hidden bg-slate-100';

                    if (file.type.startsWith('image/')) {
                        div.innerHTML = `
                            <img src="${e.target.result}" alt="${file.name}" class="h-full w-full object-cover">
                            <button type="button" class="absolute top-1 right-1 rounded-full bg-red-500 p-1 text-white hover:bg-red-600" onclick="this.parentElement.remove()">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        `;
                    } else if (file.type.startsWith('video/')) {
                        div.innerHTML = `
                            <video src="${e.target.result}" class="h-full w-full object-cover"></video>
                            <button type="button" class="absolute top-1 right-1 rounded-full bg-red-500 p-1 text-white hover:bg-red-600" onclick="this.parentElement.remove()">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        `;
                    }

                    mediaPreview.appendChild(div);
                };

                reader.readAsDataURL(file);
            });
        });
    </script>

</x-app-layout>
