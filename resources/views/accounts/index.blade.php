<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-sm font-medium text-indigo-600">
                    Workspace
                </div>

                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Social Accounts
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Connect and manage your social media accounts.
                </p>
            </div>

            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"
                    />
                </svg>

                Dashboard
            </a>
        </div>
    </x-slot>


    <div class="min-h-screen bg-slate-50">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-8 flex items-start gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="font-semibold text-emerald-900">
                            Success
                        </p>

                        <p class="mt-1 text-sm text-emerald-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif


            {{-- Page Introduction --}}
            <div class="mb-8">

                <div class="inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-indigo-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                    Social workspace
                </div>

                <h2 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Connected Accounts
                </h2>

                <p class="mt-2 max-w-2xl text-base leading-7 text-slate-500">
                    Connect your social media accounts to publish and schedule
                    content from one centralized workspace.
                </p>

            </div>


            @php
                $platforms = [
                    'facebook' => [
                        'name' => 'Facebook',
                        'description' => 'Connect your Facebook account and manage publishing access.',
                        'connect_url' => url('/auth/facebook'),
                        'color' => 'blue',
                    ],

                    'instagram' => [
                        'name' => 'Instagram',
                        'description' => 'Connect your Instagram account for scheduled publishing.',
                        'connect_url' => url('/auth/instagram'),
                        'color' => 'pink',
                    ],

                    'linkedin' => [
                        'name' => 'LinkedIn',
                        'description' => 'Connect your LinkedIn account for professional social publishing.',
                        'connect_url' => url('/auth/linkedin'),
                        'color' => 'sky',
                    ],
                ];
            @endphp


            {{-- Platform Cards --}}
            <div class="grid gap-6 lg:grid-cols-3">

                @foreach ($platforms as $platform => $info)

                    @php
                        $account = $accounts->get($platform);

                        $connected = $account &&
                            strtolower($account->status ?? 'connected') === 'connected';
                    @endphp


                    <div
                        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl"
                    >

                        {{-- Platform accent --}}
                        @if ($platform === 'facebook')
                            <div class="h-1 bg-blue-600"></div>
                        @elseif ($platform === 'instagram')
                            <div class="h-1 bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400"></div>
                        @else
                            <div class="h-1 bg-sky-600"></div>
                        @endif


                        <div class="p-6">

                            {{-- Card Header --}}
                            <div class="flex items-start justify-between gap-4">

                                {{-- Facebook --}}
                                @if ($platform === 'facebook')
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                                        <svg
                                            class="h-7 w-7"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                        >
                                            <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.413c0-3.017 1.792-4.687 4.533-4.687 1.312 0 2.686.235 2.686.235v2.953h-1.514c-1.491 0-1.955.93-1.955 1.886v2.273h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
                                        </svg>
                                    </div>

                                {{-- Instagram --}}
                                @elseif ($platform === 'instagram')
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-100 via-pink-100 to-orange-100 text-pink-600 ring-1 ring-pink-100">
                                        <svg
                                            class="h-7 w-7"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <rect
                                                x="3"
                                                y="3"
                                                width="18"
                                                height="18"
                                                rx="5"
                                            />

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="4"
                                            />

                                            <circle
                                                cx="17.5"
                                                cy="6.5"
                                                r="1"
                                                fill="currentColor"
                                                stroke="none"
                                            />
                                        </svg>
                                    </div>

                                {{-- LinkedIn --}}
                                @else
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-50 text-sky-700 ring-1 ring-sky-100">
                                        <svg
                                            class="h-7 w-7"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                        >
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V8.997h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.289zM5.337 7.433a2.062 2.062 0 110-4.124 2.062 2.062 0 010 4.124zM7.119 20.452H3.555V8.997h3.564v11.455z"/>
                                        </svg>
                                    </div>
                                @endif


                                {{-- Status --}}
                                @if ($connected)

                                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Connected
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-500 ring-1 ring-inset ring-slate-200">
                                        <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                        Not connected
                                    </span>

                                @endif

                            </div>


                            {{-- Platform Information --}}
                            <div class="mt-6">

                                <h3 class="text-xl font-bold tracking-tight text-slate-900">
                                    {{ $info['name'] }}
                                </h3>

                                <p class="mt-2 min-h-[48px] text-sm leading-6 text-slate-500">
                                    {{ $info['description'] }}
                                </p>

                            </div>


                            {{-- Connected Account --}}
                            @if ($connected)

                                <div class="mt-6 rounded-xl border border-emerald-100 bg-emerald-50/60 p-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-emerald-600 shadow-sm">
                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                                                Connected account
                                            </p>

                                            <p class="mt-0.5 truncate text-sm font-semibold text-slate-800">
                                                {{ $account->account_name ?? 'Account connected' }}
                                            </p>

                                        </div>

                                    </div>

                                    @if ($account->account_id)
                                        <div class="mt-3 border-t border-emerald-100 pt-3">
                                            <p class="text-xs text-slate-500">
                                                Account ID:
                                                <span class="font-medium text-slate-700">
                                                    {{ $account->account_id }}
                                                </span>
                                            </p>
                                        </div>
                                    @endif

                                </div>


                                {{-- Connected Actions --}}
                                <div class="mt-5 grid grid-cols-2 gap-3">

                                    <a
                                        href="{{ $info['connect_url'] }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    >
                                        Reconnect

                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                            />
                                        </svg>
                                    </a>


                                    <form
                                        action="{{ route('accounts.destroy', $platform) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to disconnect {{ $info['name'] }}?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-600 transition-all duration-200 hover:border-red-300 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                        >
                                            Disconnect

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                            </svg>
                                        </button>

                                    </form>

                                </div>

                            @else

                                {{-- Connect Button --}}
                                <div class="mt-6">

                                    @if ($platform === 'facebook')

                                        <a
                                            href="{{ $info['connect_url'] }}"
                                            class="group/button inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition-all duration-200 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                        >
                                            Connect Facebook

                                            <svg
                                                class="h-4 w-4 transition-transform duration-200 group-hover/button:translate-x-1"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 12h14m-6-6l6 6-6 6"
                                                />
                                            </svg>
                                        </a>

                                    @elseif ($platform === 'instagram')

                                        <a
                                            href="{{ $info['connect_url'] }}"
                                            class="group/button inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 via-pink-500 to-orange-500 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition-all duration-200 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2"
                                        >
                                            Connect Instagram

                                            <svg
                                                class="h-4 w-4 transition-transform duration-200 group-hover/button:translate-x-1"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 12h14m-6-6l6 6-6 6"
                                                />
                                            </svg>
                                        </a>

                                    @else

                                        <a
                                            href="{{ $info['connect_url'] }}"
                                            class="group/button inline-flex w-full items-center justify-center gap-2 rounded-xl bg-sky-700 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition-all duration-200 hover:bg-sky-800 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2"
                                        >
                                            Connect LinkedIn

                                            <svg
                                                class="h-4 w-4 transition-transform duration-200 group-hover/button:translate-x-1"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 12h14m-6-6l6 6-6 6"
                                                />
                                            </svg>
                                        </a>

                                    @endif

                                </div>

                            @endif

                        </div>
                    </div>

                @endforeach

            </div>


            {{-- Security Notice --}}
            <div class="mt-8 overflow-hidden rounded-2xl border border-indigo-100 bg-gradient-to-r from-indigo-50 via-white to-blue-50 shadow-sm">

                <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-indigo-600 shadow-sm ring-1 ring-indigo-100">

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12l2 2 4-4"
                            />
                        </svg>

                    </div>

                    <div>

                        <h3 class="font-bold text-slate-900">
                            Your account security matters
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-slate-500">
                            Social access credentials are securely handled by
                            the application and are never displayed on this page.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>