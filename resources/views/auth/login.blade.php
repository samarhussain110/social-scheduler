<x-guest-layout>

    <div class="auth-card-title">
        Welcome back
    </div>

    <div class="auth-card-description">
        Sign in to your SocialScheduler workspace and continue managing your social accounts.
    </div>

    <x-auth-session-status
        class="mb-5"
        :status="session('status')"
    />

    @if ($errors->any())
        <div
            style="
                margin-bottom: 20px;
                padding: 12px 14px;
                border: 1px solid #fecaca;
                background: #fef2f2;
                color: #b91c1c;
                border-radius: 12px;
                font-size: 13px;
                line-height: 1.5;
            "
        >
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div style="margin-bottom: 20px;">
            <label
                for="email"
                style="
                    display:block;
                    margin-bottom:7px;
                    font-size:13px;
                    font-weight:600;
                    color:#334155;
                "
            >
                Email address
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="you@example.com"
                style="
                    width:100%;
                    height:46px;
                    padding:0 14px;
                    border:1px solid #cbd5e1;
                    border-radius:11px;
                    background:#fff;
                    color:#0f172a;
                    font-size:14px;
                    outline:none;
                    box-sizing:border-box;
                "
            >
        </div>

        {{-- Password --}}
        <div style="margin-bottom: 18px;">
            <div
                style="
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    margin-bottom:7px;
                "
            >
                <label
                    for="password"
                    style="
                        font-size:13px;
                        font-weight:600;
                        color:#334155;
                    "
                >
                    Password
                </label>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        style="
                            font-size:12px;
                            font-weight:600;
                            color:#4f46e5;
                            text-decoration:none;
                        "
                    >
                        Forgot password?
                    </a>
                @endif
            </div>

            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
                style="
                    width:100%;
                    height:46px;
                    padding:0 14px;
                    border:1px solid #cbd5e1;
                    border-radius:11px;
                    background:#fff;
                    color:#0f172a;
                    font-size:14px;
                    outline:none;
                    box-sizing:border-box;
                "
            >
        </div>

        {{-- Remember --}}
        <label
            style="
                display:flex;
                align-items:center;
                gap:9px;
                margin-bottom:22px;
                cursor:pointer;
                font-size:13px;
                color:#64748b;
            "
        >
            <input
                type="checkbox"
                name="remember"
                style="
                    width:16px;
                    height:16px;
                    accent-color:#4f46e5;
                "
            >

            Remember me
        </label>

        {{-- Login Button --}}
        <button
            type="submit"
            style="
                width:100%;
                height:47px;
                border:0;
                border-radius:11px;
                background:linear-gradient(135deg,#4f46e5,#2563eb);
                color:white;
                font-size:14px;
                font-weight:700;
                cursor:pointer;
                box-shadow:0 8px 20px rgba(79,70,229,.22);
            "
        >
            Sign in
        </button>

    </form>

</x-guest-layout>