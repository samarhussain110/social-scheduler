<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SocialScheduler') }}</title>



    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .auth-page {
            min-height: 100vh;
            background:
                radial-gradient(circle at 10% 10%, rgba(79, 70, 229, 0.10), transparent 32%),
                radial-gradient(circle at 90% 90%, rgba(37, 99, 235, 0.08), transparent 30%),
                #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .auth-shell {
            width: 100%;
            max-width: 440px;
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-logo {
            width: 52px;
            height: 52px;
            margin: 0 auto 14px;
            border-radius: 16px;
            background: linear-gradient(135deg, #4f46e5, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: 800;
            box-shadow: 0 12px 30px rgba(79, 70, 229, 0.25);
        }

        .auth-brand-title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
        }

        .auth-brand-subtitle {
            margin-top: 5px;
            font-size: 14px;
            color: #64748b;
        }

        .auth-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 22px;
            padding: 32px;
            box-shadow:
                0 20px 50px rgba(15, 23, 42, 0.08),
                0 4px 12px rgba(15, 23, 42, 0.04);
        }

        .auth-card-title {
            margin-bottom: 6px;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
        }

        .auth-card-description {
            margin-bottom: 26px;
            font-size: 14px;
            line-height: 1.6;
            color: #64748b;
        }

        .auth-footer {
            margin-top: 22px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="auth-page">
        <div class="auth-shell">

            <div class="auth-brand">
                <div class="auth-logo">S</div>

                <div class="auth-brand-title">
                    SocialScheduler
                </div>

                <div class="auth-brand-subtitle">
                    Manage your social presence from one place
                </div>
            </div>

            <div class="auth-card">
                {{ $slot }}
            </div>

            <div class="auth-footer">
                Secure social publishing workspace
            </div>

        </div>
    </div>
</body>
</html>