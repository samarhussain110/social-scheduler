<x-app-layout>

    @php
        /*
        |--------------------------------------------------------------------------
        | Dynamic Social Account Status
        |--------------------------------------------------------------------------
        */
        $dashboardAccounts = \App\Models\SocialAccount::where('user_id', Auth::id())
            ->where('status', 'connected')
            ->get()
            ->keyBy('platform');

        $connectedCount = $dashboardAccounts->count();

        $facebookAccount = $dashboardAccounts->get('facebook');
        $instagramAccount = $dashboardAccounts->get('instagram');
        $linkedinAccount = $dashboardAccounts->get('linkedin');
    @endphp


    {{-- =========================================================
         PROFESSIONAL DASHBOARD
    ========================================================== --}}

    <div class="min-h-screen bg-slate-50">

        {{-- TOP HEADER --}}
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-6 lg:px-8">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Workspace
                    </p>

                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                        Dashboard
                    </h1>
                </div>

                <div class="hidden items-center gap-3 sm:flex">

                    <a
                        href="{{ route('accounts.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>

                        Connect Account
                    </a>

                </div>

            </div>
        </header>


        {{-- MAIN CONTENT --}}
        <main class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8">


{{-- =========================================================
     PREMIUM DASHBOARD HERO
========================================================= --}}
<section
    style="
        position:relative;
        overflow:hidden;
        margin-bottom:40px;
        border-radius:24px;
        background:linear-gradient(135deg,#111827 0%,#172554 52%,#312e81 100%);
        box-shadow:0 20px 50px rgba(145, 151, 165, 0.43);
    "
>

    {{-- subtle background glow --}}
    <div
        aria-hidden="true"
        style="
            position:absolute;
            width:420px;
            height:420px;
            right:-170px;
            top:-210px;
            border-radius:9999px;
            background:rgb(62, 113, 194);
            filter:blur(70px);
            pointer-events:none;
            z-index:0;
        "
    ></div>

    <div
        aria-hidden="true"
        style="
            position:absolute;
            width:280px;
            height:280px;
            left:42%;
            bottom:-190px;
            border-radius:9999px;
            background:rgba(112, 158, 231, 0.81);
            filter:blur(60px);
            pointer-events:none;
            z-index:0;
        "
    ></div>


    {{-- Main content --}}
    <div
        style="
            position:relative;
            z-index:2;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:40px;
            padding:42px 46px;
        "
        class="flex-col lg:flex-row"
    >

        {{-- =================================================
             LEFT
        ================================================== --}}
        <div
            style="
                position:relative;
                z-index:3;
                flex:1;
                min-width:0;
            "
        >

            {{-- Badge --}}
            <div
                style="
                    display:inline-flex;
                    align-items:center;
                    gap:9px;
                    padding:8px 14px;
                    margin-bottom:18px;
                    border-radius:9999px;
                    border:1px solid white;
                    background:rgba(57, 27, 167, 0.58);
                    color:#ffffff;
                    font-size:11px;
                    font-weight:700;
                    letter-spacing:.08em;
                    white-space:nowrap;
                "
            >
                <span
                    style="
                        width:8px;
                        height:8px;
                        border-radius:50%;
                        background:#34d399;
                        box-shadow:0 0 0 4px rgba(52,211,153,.10);
                    "
                ></span>

                YOUR SOCIAL WORKSPACE
            </div>


            {{-- Heading --}}
            <h2
                style="
                    margin:0;
                    color:#ffffff;
                    font-size:42px;
                    line-height:1.12;
                    font-weight:750;
                    letter-spacing:-.035em;
                "
                class="text-3xl sm:text-4xl"
            >
                Welcome back, {{ Auth::user()->name }} 
            </h2>


            {{-- Description --}}
            <p
                style="
                    max-width:610px;
                    margin:15px 0 0 0;
                    color:#c7d2fe;
                    font-size:15px;
                    line-height:1.75;
                "
            >
                Connect your social accounts, manage your publishing
                workflow and keep everything organized from one place.
            </p>


            {{-- Small trust points --}}
            <div
                style="
                    display:flex;
                    flex-wrap:wrap;
                    align-items:center;
                    gap:22px;
                    margin-top:24px;
                "
            >

                <div
                    style="
                        display:flex;
                        align-items:center;
                        gap:8px;
                        color:#e0e7ff;
                        font-size:12px;
                        font-weight:500;
                    "
                >
                    <span
                        style="
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            width:22px;
                            height:22px;
                            border-radius:50%;
                            background:rgba(52,211,153,.13);
                            color:#6ee7b7;
                        "
                    >
                        ✓
                    </span>

                    Everything in one place
                </div>


                <div
                    style="
                        display:flex;
                        align-items:center;
                        gap:8px;
                        color:#e0e7ff;
                        font-size:12px;
                        font-weight:500;
                    "
                >
                    <span
                        style="
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            width:22px;
                            height:22px;
                            border-radius:50%;
                            background:rgba(129,140,248,.14);
                            color:#c7d2fe;
                        "
                    >
                        ✓
                    </span>

                    Secure social access
                </div>

            </div>

        </div>


        {{-- =================================================
             RIGHT SIDE
        ================================================== --}}
        <div
            style="
                position:relative;
                z-index:3;
                display:flex;
                align-items:center;
                gap:18px;
                flex-shrink:0;
            "
            class="flex-col sm:flex-row"
        >

            {{-- Mini visual --}}
            <div
                style="
                    width:210px;
                    padding:16px;
                    border-radius:18px;
                    border:1px solid rgba(255,255,255,.12);
                    background:rgba(255,255,255,.06);
                    backdrop-filter:blur(12px);
                "
                class="hidden sm:block"
            >

                <div
                    style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                    "
                >

                    <div>
                        <div
                            style="
                                color:#94a3b8;
                                font-size:9px;
                                font-weight:700;
                                text-transform:uppercase;
                                letter-spacing:.08em;
                            "
                        >
                            Workspace
                        </div>

                        <div
                            style="
                                margin-top:3px;
                                color:#ffffff;
                                font-size:12px;
                                font-weight:700;
                            "
                        >
                            Social activity
                        </div>
                    </div>

                    <div
                        style="
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            width:30px;
                            height:30px;
                            border-radius:9px;
                            background:rgba(122, 124, 224, 0.69);
                            color:#c7d2fe;
                        "
                    >
                        ↗
                    </div>

                </div>


                {{-- Chart --}}
                <div
                    style="
                        display:flex;
                        align-items:flex-end;
                        gap:5px;
                        height:42px;
                        margin-top:16px;
                    "
                >
                    <span style="width:7px;height:28%;border-radius:4px 4px 0 0;background:#475569;"></span>
                    <span style="width:7px;height:40%;border-radius:4px 4px 0 0;background:#64748b;"></span>
                    <span style="width:7px;height:34%;border-radius:4px 4px 0 0;background:#818cf8;"></span>
                    <span style="width:7px;height:55%;border-radius:4px 4px 0 0;background:#818cf8;"></span>
                    <span style="width:7px;height:48%;border-radius:4px 4px 0 0;background:#a5b4fc;"></span>
                    <span style="width:7px;height:72%;border-radius:4px 4px 0 0;background:#a5b4fc;"></span>
                    <span style="width:7px;height:88%;border-radius:4px 4px 0 0;background:#c7d2fe;"></span>
                    <span style="width:7px;height:100%;border-radius:4px 4px 0 0;background:#ffffff;"></span>
                </div>


                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        margin-top:10px;
                        color:#94a3b8;
                        font-size:9px;
                    "
                >
                    <span>Platforms</span>

                    <span style="color:#6ee7b7;font-weight:700;">
                        Ready
                    </span>
                </div>

            </div>


            {{-- CTA --}}
            <a
                href="{{ route('accounts.index') }}"
                style="
                    display:flex;
                    align-items:center;
                    gap:12px;
                    padding:13px 18px 13px 13px;
                    min-width:235px;
                    border-radius:16px;
                    background:#ffffff;
                    color:#312e81;
                    text-decoration:none;
                    font-size:13px;
                    font-weight:700;
                    box-shadow:0 12px 28px rgba(0,0,0,.20);
                    transition:all .2s ease;
                "
            >

                <span
                    style="
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        width:40px;
                        height:40px;
                        border-radius:12px;
                        background:#4f46e5;
                        color:#ffffff;
                        font-size:25px;
                        font-weight:300;
                        line-height:1;
                    "
                >
                    +
                </span>

                <span style="flex:1;">
                    Manage Social Accounts
                </span>

                <span
                    style="
                        font-size:20px;
                        font-weight:400;
                        color:#4f46e5;
                    "
                >
                    ›
                </span>

            </a>

        </div>

    </div>

</section>


            {{-- =====================================================
                 STATISTICS
            ====================================================== --}}
            <section class="mb-10">

                <div class="mb-5">
                    <h3 class="text-lg font-bold text-slate-900">
                        Overview
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        A quick look at your workspace.
                    </p>
                </div>


                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">


                    {{-- Connected Accounts --}}
                    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Connected Accounts
                                </p>

                                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                                    {{ $connectedCount }}
                                </p>

                                <p class="mt-2 text-xs font-medium text-slate-400">
                                    Social profiles connected
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m6-8a4 4 0 100-8 4 4 0 000 8zm10 8v-2a4 4 0 00-3-3.87m-1-8a4 4 0 010 7.75"/>
                                </svg>

                            </div>

                        </div>

                    </div>


                    {{-- Scheduled --}}
                    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Scheduled Posts
                                </p>

                                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                                    0
                                </p>

                                <p class="mt-2 text-xs font-medium text-slate-400">
                                    Upcoming publications
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>

                            </div>

                        </div>

                    </div>


                    {{-- Published --}}
                    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Published
                                </p>

                                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                                    0
                                </p>

                                <p class="mt-2 text-xs font-medium text-slate-400">
                                    Posts published
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M5 13l4 4L19 7"/>
                                </svg>

                            </div>

                        </div>

                    </div>


                    {{-- Account Status --}}
                    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-sm font-medium text-slate-500">
                                    Account Status
                                </p>

                                <p class="mt-3 text-xl font-bold tracking-tight text-slate-900">
                                    Active
                                </p>

                                <p class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    Everything looks good
                                </p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 12c0 5.591 3.824 10.291 9 11.622C17.176 22.291 21 17.591 21 12c0-1.41-.244-2.764-.694-4.016z"/>
                                </svg>

                            </div>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 SOCIAL ACCOUNTS
            ====================================================== --}}
            <section class="mb-10">

                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                    <div>
                        <h3 class="text-lg font-bold text-slate-900">
                            Social Accounts
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Connect your platforms to start publishing.
                        </p>
                    </div>

                    <a
                        href="{{ route('accounts.index') }}"
                        class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-700"
                    >
                        View all accounts →
                    </a>

                </div>


                <div class="grid gap-5 lg:grid-cols-3">


                    {{-- =================================================
                         FACEBOOK
                    ================================================== --}}
                    <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                        <div class="absolute inset-x-0 top-0 h-1 bg-blue-600"></div>

                        <div class="p-6">

                            <div class="flex items-start justify-between">

                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50">

                                    <svg class="h-7 w-7 text-blue-600"
                                         fill="currentColor"
                                         viewBox="0 0 24 24">
                                        <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073c0 6.02 4.388 11.003 10.125 11.926v-8.437H7.078v-3.49h3.047V9.413c0-3.02 1.79-4.688 4.532-4.688 1.313 0 2.686.236 2.686.236v2.973h-1.515c-1.492 0-1.953.93-1.953 1.885v2.253h3.328l-.532 3.49h-2.796V24C19.612 23.076 24 18.093 24 12.073z"/>
                                    </svg>

                                </div>

                                @if ($facebookAccount)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Connected
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-500">
                                        <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                        Not connected
                                    </span>
                                @endif

                            </div>

                            <div class="mt-6">

                                <h4 class="text-xl font-bold text-slate-900">
                                    Facebook
                                </h4>

                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    Connect Facebook to manage your social publishing workflow.
                                </p>

                            </div>

                            <a
                                href="{{ route('accounts.index') }}"
                                class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white transition duration-200 hover:bg-blue-700 hover:shadow-lg"
                            >
                                {{ $facebookAccount ? 'Manage Facebook' : 'Connect Facebook' }}

                                <svg class="h-4 w-4"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 5l7 7-7 7"/>
                                </svg>

                            </a>

                        </div>

                    </div>



                    {{-- =================================================
                         INSTAGRAM
                    ================================================== --}}
                    <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-purple-500 via-pink-500 to-orange-400"></div>

                        <div class="p-6">

                            <div class="flex items-start justify-between">

                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-50">

                                    <svg class="h-7 w-7 text-pink-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <rect x="3" y="3" width="18" height="18" rx="5"
                                              stroke="currentColor"
                                              stroke-width="2"/>

                                        <circle cx="12" cy="12" r="4"
                                                stroke="currentColor"
                                                stroke-width="2"/>

                                        <circle cx="17.5" cy="6.5" r="1"
                                                fill="currentColor"/>

                                    </svg>

                                </div>

                                @if ($instagramAccount)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Connected
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-500">
                                        <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                        Not connected
                                    </span>
                                @endif

                            </div>

                            <div class="mt-6">

                                <h4 class="text-xl font-bold text-slate-900">
                                    Instagram
                                </h4>

                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    Connect Instagram and manage your publishing workflow.
                                </p>

                            </div>

                            <a
                                href="{{ route('accounts.index') }}"
                                class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 px-4 py-3 text-sm font-bold text-white shadow-sm transition duration-200 hover:shadow-lg"
                            >
                                {{ $instagramAccount ? 'Manage Instagram' : 'Connect Instagram' }}

                                <svg class="h-4 w-4"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 5l7 7-7 7"/>
                                </svg>

                            </a>

                        </div>

                    </div>



                    {{-- =================================================
                         LINKEDIN
                    ================================================== --}}
                    <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                        <div class="absolute inset-x-0 top-0 h-1 bg-sky-700"></div>

                        <div class="p-6">

                            <div class="flex items-start justify-between">

                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-50">

                                    <svg class="h-7 w-7 text-sky-700"
                                         fill="currentColor"
                                         viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.605 0 4.27 2.373 4.27 5.467v6.274zM5.337 7.433a2.062 2.062 0 110-4.124 2.062 2.062 0 010 4.124zM7.119 20.452H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 .774 22.225 0z"/>
                                    </svg>

                                </div>

                                @if ($linkedinAccount)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Connected
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-500">
                                        <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                        Not connected
                                    </span>
                                @endif

                            </div>

                            <div class="mt-6">

                                <h4 class="text-xl font-bold text-slate-900">
                                    LinkedIn
                                </h4>

                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    Connect LinkedIn for professional social publishing.
                                </p>

                            </div>

                            <a
                                href="{{ route('accounts.index') }}"
                                class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-sky-700 px-4 py-3 text-sm font-bold text-white transition duration-200 hover:bg-sky-800 hover:shadow-lg"
                            >
                                {{ $linkedinAccount ? 'Manage LinkedIn' : 'Connect LinkedIn' }}

                                <svg class="h-4 w-4"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 5l7 7-7 7"/>
                                </svg>

                            </a>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =====================================================
                 QUICK ACTIONS
            ====================================================== --}}
            <section>

                <div class="mb-5">

                    <h3 class="text-lg font-bold text-slate-900">
                        Quick Actions
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Jump directly to the tools you use most.
                    </p>

                </div>


                <div class="grid gap-4 md:grid-cols-3">


                    {{-- Manage Accounts --}}
                    <a
                        href="{{ route('accounts.index') }}"
                        class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg"
                    >

                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                                <svg class="h-5 w-5"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M13.828 10.172a4 4 0 010 5.656l-3 3a4 4 0 01-5.656-5.656l1.5-1.5m9.328-4.328l1.5-1.5a4 4 0 00-5.656-5.656l-3 3a4 4 0 000 5.656"/>
                                </svg>

                            </div>

                            <div>
                                <h4 class="font-semibold text-slate-900">
                                    Manage Accounts
                                </h4>

                                <p class="mt-1 text-sm text-slate-500">
                                    Connect or reconnect accounts
                                </p>
                            </div>

                        </div>

                        <svg class="h-5 w-5 text-slate-300 transition group-hover:translate-x-1 group-hover:text-indigo-600"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>


                    {{-- Scheduled Posts --}}
                    <a
                        href="{{ route('posts.index') }}"
                        class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg"
                    >

                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600">

                                <svg class="h-5 w-5"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>

                            </div>

                            <div>
                                <h4 class="font-semibold text-slate-900">
                                    Scheduled Posts
                                </h4>

                                <p class="mt-1 text-sm text-slate-500">
                                    View your scheduled posts
                                </p>
                            </div>

                        </div>

                        <svg class="h-5 w-5 text-slate-300 transition group-hover:translate-x-1 group-hover:text-indigo-600"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>


                    {{-- Profile --}}
                    <a
                        href="{{ route('profile.edit') }}"
                        class="group flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-slate-300 hover:shadow-lg"
                    >

                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-700">

                                <svg class="h-5 w-5"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M15 19a3 3 0 10-6 0m9-10a6 6 0 11-12 0 6 6 0 0112 0z"/>
                                </svg>

                            </div>

                            <div>
                                <h4 class="font-semibold text-slate-900">
                                    Profile Settings
                                </h4>

                                <p class="mt-1 text-sm text-slate-500">
                                    Manage your account
                                </p>
                            </div>

                        </div>

                        <svg class="h-5 w-5 text-slate-300 transition group-hover:translate-x-1 group-hover:text-slate-700"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 5l7 7-7 7"/>
                        </svg>

                    </a>

                </div>

            </section>

        </main>

    </div>

</x-app-layout>