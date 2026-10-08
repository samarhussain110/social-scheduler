<nav
    class="fixed left-0 top-0 z-50 hidden h-screen w-[250px] flex-col bg-[#07101f] text-white shadow-2xl lg:flex"
>

    {{-- =========================
         BRAND
    ========================== --}}
    <div class="flex h-[82px] shrink-0 items-center border-b border-white/10 px-5">

        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3"
        >

            {{-- Logo --}}
            <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-white shadow-lg">
                <img
                    src="{{ asset('images/socialscheduler-logo.png') }}"
                    alt="SocialScheduler"
                    class="h-full w-full object-contain p-1"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >

                {{-- Fallback --}}
                <span
                    class="hidden h-full w-full items-center justify-center bg-gradient-to-br from-indigo-500 to-violet-600 text-lg font-extrabold text-white"
                >
                    S
                </span>
            </div>

            <div class="min-w-0">
                <div class="text-[17px] font-bold tracking-tight text-white">
                    Social<span class="text-indigo-400">Scheduler</span>
                </div>

                <div class="mt-0.5 text-[9px] uppercase tracking-[0.16em] text-slate-400">
                    Social Workspace
                </div>
            </div>

        </a>

    </div>


    {{-- =========================
         NAVIGATION
    ========================== --}}
    <div class="flex min-h-0 flex-1 flex-col px-3 py-5">

        {{-- Section --}}
        <div class="mb-3 px-3 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">
            Workspace
        </div>

        <div class="space-y-1.5">

            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition duration-200
                {{ request()->routeIs('dashboard')
                    ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-950/40'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >

                <span
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                    {{ request()->routeIs('dashboard')
                        ? 'bg-white/15'
                        : 'bg-white/5 group-hover:bg-white/10' }}"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6"
                        />
                    </svg>
                </span>

                <span>Dashboard</span>

            </a>


            {{-- Accounts --}}
            <a
                href="{{ route('accounts.index') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition duration-200
                {{ request()->routeIs('accounts.*')
                    ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-950/40'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >

                <span
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                    {{ request()->routeIs('accounts.*')
                        ? 'bg-white/15'
                        : 'bg-white/5 group-hover:bg-white/10' }}"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                        />
                    </svg>
                </span>

                <span>Accounts</span>

            </a>


            {{-- Create Post --}}
            @if (Route::has('posts.create'))

                <a
                    href="{{ route('posts.create') }}"
                    class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-300 transition duration-200 hover:bg-white/5 hover:text-white"
                >

                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/5 group-hover:bg-white/10">
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 20h9M16.5 3.5a2.12 2.12 0 013 3L8 18l-4 1 1-4 11.5-11.5z"
                            />
                        </svg>
                    </span>

                    <span>Create Post</span>

                </a>

            @endif


            {{-- Scheduled Posts --}}
            @if (Route::has('posts.index'))

                <a
                    href="{{ route('posts.index') }}"
                    class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-300 transition duration-200 hover:bg-white/5 hover:text-white"
                >

                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/5 group-hover:bg-white/10">
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8 7V3M16 7V3M4 11h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"
                            />
                        </svg>
                    </span>

                    <span>Scheduled Posts</span>

                </a>

            @endif


            {{-- Notifications --}}
            @if (Route::has('notifications.index'))

                <a
                    href="{{ route('notifications.index') }}"
                    class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-300 transition duration-200 hover:bg-white/5 hover:text-white"
                >

                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/5 group-hover:bg-white/10">
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                            />
                        </svg>
                    </span>

                    <span>Notifications</span>

                    @if (auth()->check() && auth()->user()->notifications()->unread()->count() > 0)
                        <span class="ml-auto flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white">
                            {{ auth()->user()->notifications()->unread()->count() }}
                        </span>
                    @endif

                </a>

            @endif


            {{-- Activity Logs --}}
            @if (Route::has('activity-logs.index'))

                <a
                    href="{{ route('activity-logs.index') }}"
                    class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-300 transition duration-200 hover:bg-white/5 hover:text-white"
                >

                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/5 group-hover:bg-white/10">
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                            />
                        </svg>
                    </span>

                    <span>Activity Logs</span>

                </a>

            @endif


            {{-- All Posts --}}
            @if (Route::has('posts.status'))

                <a
                    href="{{ route('posts.status') }}"
                    class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-300 transition duration-200 hover:bg-white/5 hover:text-white"
                >

                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/5 group-hover:bg-white/10">
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 6h16M4 12h16M4 18h10"
                            />
                        </svg>
                    </span>

                    <span>All Posts</span>

                </a>

            @endif

        </div>


        {{-- =========================
             BOTTOM
        ========================== --}}
        <div class="mt-auto space-y-1.5 border-t border-white/10 pt-5">

            {{-- Profile --}}
            @if (Route::has('profile.edit'))

                <a
                    href="{{ route('profile.edit') }}"
                    class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition duration-200
                    {{ request()->routeIs('profile.*')
                        ? 'bg-white/10 text-white'
                        : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                >

                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/5 group-hover:bg-white/10">

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M20 21a8 8 0 00-16 0M12 13a4 4 0 100-8 4 4 0 000 8"
                            />
                        </svg>

                    </span>

                    <span>Profile</span>

                </a>

            @endif


            {{-- Logout --}}
            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="group flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-slate-300 transition duration-200 hover:bg-red-500/10 hover:text-red-300"
                >

                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/5 group-hover:bg-red-500/10">

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M15 3h4a1 1 0 011 1v16a1 1 0 01-1 1h-4M10 17l5-5-5-5M15 12H3"
                            />
                        </svg>

                    </span>

                    <span>Log out</span>

                </button>

            </form>

        </div>

    </div>

</nav>