<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SocialScheduler</title>

    <!-- SocialScheduler browser tab icon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0' y1='0' x2='1' y2='1'%3E%3Cstop offset='0%25' stop-color='%23536dfe'/%3E%3Cstop offset='100%25' stop-color='%2313b8e9'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='64' height='64' rx='16' fill='url(%23g)'/%3E%3Ctext x='32' y='45' text-anchor='middle' font-family='Arial,sans-serif' font-size='38' font-weight='800' fill='white'%3ES%3C/text%3E%3C/svg%3E">
    
    

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #172554;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: min(1180px, 92%);
            margin: auto;
        }

        /* =========================
           HEADER
        ========================= */

        header {
            height: 78px;
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid #edf1f8;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(12px);
        }

        .nav {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 800;
            color: #172554;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #536dfe, #13b8e9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 21px;
            font-weight: 800;
            box-shadow: 0 8px 20px rgba(83,109,254,.22);
        }

        .brand span {
            color: #4f46e5;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
            font-size: 14px;
            color: #52607a;
            font-weight: 500;
        }

        .nav-links a {
            transition: .25s;
        }

        .nav-links a:hover {
            color: #4f46e5;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .login-link {
            font-size: 14px;
            font-weight: 600;
            color: #172554;
        }

        .login-link:hover {
            color: #4f46e5;
        }

        .nav-btn,
        .primary-btn {
            border: none;
            cursor: pointer;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            background: linear-gradient(100deg, #6447f5, #10aeea);
            box-shadow: 0 10px 25px rgba(79,70,229,.20);
            transition: .25s;
        }

        .nav-btn {
            padding: 11px 20px;
            font-size: 13px;
        }

        .nav-btn:hover,
        .primary-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(79,70,229,.28);
        }

        /* =========================
           HERO
        ========================= */

        .hero {
            position: relative;
            padding: 85px 0 90px;
            overflow: hidden;
            background:
                radial-gradient(circle at 78% 35%, rgba(113,91,255,.12), transparent 27%),
                radial-gradient(circle at 92% 70%, rgba(15,185,234,.10), transparent 25%),
                linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 65px;
            align-items: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 15px;
            background: #f0efff;
            border: 1px solid #dfdcff;
            color: #5b4ee7;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: clamp(42px, 5vw, 64px);
            line-height: 1.06;
            letter-spacing: -2.5px;
            color: #172554;
            font-weight: 800;
            margin-bottom: 24px;
        }

        .gradient-text {
            background: linear-gradient(100deg, #168eea, #5d42ed, #7b43e9);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-description {
            max-width: 570px;
            color: #5c6b85;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 25px;
            font-size: 14px;
        }

        .hero-points {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
            margin-top: 25px;
            color: #60708b;
            font-size: 12px;
            font-weight: 500;
        }

        .hero-point {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .check {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #5b5af2;
            color: white;
            border-radius: 50%;
            font-size: 10px;
        }

        /* Dashboard mockup */

        .hero-visual {
            position: relative;
        }

        .social-floating {
            position: absolute;
            width: 54px;
            height: 54px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 15px 35px rgba(44,62,110,.14);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
        }

        .social-floating.facebook {
            top: -35px;
            left: 70px;
        }

        .social-floating.instagram {
            top: -70px;
            right: 180px;
        }

        .social-floating.linkedin {
            top: 5px;
            right: 40px;
        }

        .social-icon {
            width: 31px;
            height: 31px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 19px;
            overflow: hidden;
        }

        .social-icon svg,
        .account-icon svg,
        .platform-logo svg {
            width: 68%;
            height: 68%;
            display: block;
            flex: 0 0 auto;
        }

        .account-icon svg {
            width: 70%;
            height: 70%;
        }

        .platform-logo svg {
            width: 62%;
            height: 62%;
        }

        .facebook-bg {
            background: #1877f2;
        }

        .instagram-bg {
            background: linear-gradient(135deg,#feda75,#fa7e1e,#d62976,#962fbf,#4f5bd5);
        }

        .linkedin-bg {
            background: #0a66c2;
        }

        .dashboard-window {
            position: relative;
            background: white;
            border: 1px solid #e6ebf5;
            border-radius: 22px;
            box-shadow: 0 30px 70px rgba(39,64,120,.16);
            overflow: hidden;
            padding: 18px;
            transform: perspective(1000px) rotateY(-2deg);
        }

        .dashboard-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 4px 8px 15px;
            border-bottom: 1px solid #edf1f7;
        }

        .mini-brand {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 800;
        }

        .mini-logo {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            background: linear-gradient(135deg,#6048f5,#11b9e7);
        }

        .dashboard-body {
            display: grid;
            grid-template-columns: 125px 1fr 155px;
            min-height: 280px;
        }

        .side-menu {
            padding: 20px 8px 10px;
            border-right: 1px solid #edf1f7;
        }

        .side-item {
            padding: 9px 10px;
            margin-bottom: 6px;
            border-radius: 8px;
            font-size: 9px;
            color: #72809a;
        }

        .side-item.active {
            color: #5a4ce9;
            background: #f1efff;
            font-weight: 700;
        }


        .side-item {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .mock-icon {
            width: 13px;
            height: 13px;
            flex: 0 0 13px;
            display: block;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .mock-icon.fill {
            fill: currentColor;
            stroke: none;
        }

        .post-thumb {
            width: 42px;
            height: 42px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 42px;
            overflow: hidden;
            background: linear-gradient(135deg, #eaf0ff, #dce8ff);
        }

        .post-thumb.facebook-thumb {
            background: #1877f2;
        }

        .post-thumb.instagram-thumb {
            background: linear-gradient(135deg, #feda75, #d62976 55%, #4f5bd5);
        }

        .post-thumb.linkedin-thumb {
            background: #0a66c2;
        }

        .post-thumb svg {
            width: 23px;
            height: 23px;
            display: block;
        }

        .post-area {
            padding: 20px;
        }

        .post-heading {
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .post-box {
            height: 115px;
            border: 1px solid #e8edf5;
            border-radius: 10px;
            padding: 13px;
            color: #9ba6b8;
            font-size: 10px;
        }

        .schedule-btn {
            width: 100%;
            border: none;
            padding: 10px;
            margin-top: 12px;
            border-radius: 8px;
            color: white;
            background: linear-gradient(100deg,#6249ef,#16afe5);
            font-size: 10px;
            font-weight: 700;
        }

        .connected {
            padding: 20px 10px;
            border-left: 1px solid #edf1f7;
        }

        .connected-title {
            font-size: 10px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .account {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px;
            margin-bottom: 8px;
            border: 1px solid #edf1f7;
            border-radius: 9px;
        }

        .account-icon {
            width: 25px;
            height: 25px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 800;
        }

        .account-name {
            font-size: 9px;
            font-weight: 700;
        }

        .connected-status {
            color: #19ad73;
            font-size: 7px;
            margin-top: 2px;
        }

        /* =========================
           PLATFORM SECTION
        ========================= */

        .platform-section {
            padding: 90px 0;
            background: white;
        }

        .section-heading {
            text-align: center;
            max-width: 720px;
            margin: auto;
        }

        .eyebrow {
            color: #6551ee;
            font-size: 12px;
            letter-spacing: 2px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .section-heading h2 {
            font-size: 34px;
            line-height: 1.2;
            color: #172554;
            margin-bottom: 14px;
        }

        .section-heading p {
            color: #6c7890;
            line-height: 1.7;
            font-size: 14px;
        }

        .platform-grid {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 25px;
            margin-top: 45px;
        }

        .platform-card {
            padding: 30px;
            border-radius: 18px;
            border: 1px solid #e4eaf4;
            background: linear-gradient(145deg,#ffffff,#f8fbff);
            transition: .3s;
            position: relative;
            overflow: hidden;
        }

        .platform-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 20px 45px rgba(50,70,120,.11);
        }

        .platform-card::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            background: #eef4ff;
            border-radius: 50%;
            right: -40px;
            top: -40px;
        }

        .platform-logo {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 25px;
            font-weight: 800;
            margin-bottom: 22px;
        }

        .platform-card h3 {
            font-size: 19px;
            margin-bottom: 9px;
            color: #172554;
        }

        .platform-card p {
            font-size: 13px;
            line-height: 1.7;
            color: #6b7890;
        }

        /* =========================
           HOW IT WORKS
        ========================= */

        .how-section {
            padding: 90px 0;
            background: linear-gradient(180deg,#f6f8ff,#eef6ff);
            position: relative;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 35px;
            margin-top: 55px;
        }

        .step {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 48px;
            height: 48px;
            margin: auto auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 15px;
            font-weight: 800;
            background: linear-gradient(135deg,#6650f4,#19afe8);
            box-shadow: 0 10px 25px rgba(85,77,235,.2);
        }

        .step h3 {
            font-size: 16px;
            color: #172554;
            margin-bottom: 9px;
        }

        .step p {
            color: #6b7890;
            font-size: 13px;
            line-height: 1.7;
            max-width: 260px;
            margin: auto;
        }

        /* =========================
           FEATURES
        ========================= */

        .features-section {
            padding: 100px 0;
            background: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 70px;
            align-items: center;
        }

        .features-content h2 {
            font-size: 38px;
            line-height: 1.18;
            color: #172554;
            margin-bottom: 18px;
        }

        .features-content > p {
            color: #697791;
            font-size: 14px;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #53617a;
            font-size: 13px;
        }

        .feature-check {
            width: 19px;
            height: 19px;
            border-radius: 50%;
            background: #6752ee;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .schedule-preview {
            border: 1px solid #e1e7f1;
            border-radius: 22px;
            padding: 22px;
            box-shadow: 0 25px 60px rgba(40,60,110,.12);
            background: white;
        }

        .preview-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .preview-title strong {
            font-size: 13px;
        }

        .preview-filter {
            padding: 6px 10px;
            border-radius: 8px;
            background: #f2f0ff;
            color: #6250e8;
            font-size: 9px;
            font-weight: 700;
        }

        .post-row {
            display: grid;
            grid-template-columns: 42px 1fr 80px 70px;
            align-items: center;
            gap: 10px;
            padding: 12px 0;
            border-bottom: 1px solid #eef1f6;
        }

        .post-thumb {
            width: 42px;
            height: 42px;
            border-radius: 9px;
            background: linear-gradient(135deg,#dbeafe,#eef2ff);
        }

        .post-name {
            font-size: 10px;
            font-weight: 700;
            color: #35415a;
        }

        .post-platform {
            font-size: 8px;
            color: #718098;
            margin-top: 3px;
        }

        .post-date {
            font-size: 8px;
            color: #748099;
        }

        .status {
            justify-self: end;
            padding: 5px 8px;
            border-radius: 20px;
            background: #e8faf2;
            color: #159968;
            font-size: 8px;
            font-weight: 700;
        }

        /* =========================
           TESTIMONIALS
        ========================= */

        .testimonial-section {
            padding: 85px 0;
            background: #f5f7ff;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 22px;
            margin-top: 42px;
        }

        .testimonial {
            background: white;
            border: 1px solid #e6eaf3;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(48,62,105,.06);
        }

        .person {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 17px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg,#684cf4,#13b3e8);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .person strong {
            display: block;
            font-size: 12px;
        }

        .person span {
            font-size: 9px;
            color: #8791a5;
        }

        .testimonial p {
            color: #68758c;
            font-size: 11px;
            line-height: 1.8;
        }

        .stars {
            color: #f7b928;
            font-size: 13px;
            margin-top: 13px;
        }

        /* =========================
           CTA
        ========================= */

        .cta-section {
            padding: 75px 0;
            background: linear-gradient(100deg,#f0efff,#ecf9ff);
        }

        .cta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }

        .cta-label {
            color: #6651ed;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            margin-bottom: 10px;
        }

        .cta h2 {
            font-size: 32px;
            color: #172554;
            margin-bottom: 8px;
        }

        .cta p {
            color: #68758c;
            font-size: 13px;
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            padding: 35px 0;
            background: white;
            border-top: 1px solid #edf1f6;
        }

        .footer-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }

        .footer-links {
            display: flex;
            gap: 25px;
            color: #65718a;
            font-size: 11px;
        }

        .footer-links a:hover {
            color: #5547e8;
        }

        .copyright {
            color: #8791a4;
            font-size: 10px;
        }

        /* =========================
           MOBILE
        ========================= */

        @media(max-width: 900px) {

            .nav-links {
                display: none;
            }

            .hero-grid,
            .features-grid {
                grid-template-columns: 1fr;
            }

            .hero {
                padding-top: 60px;
            }

            .hero-visual {
                margin-top: 35px;
            }

            .platform-grid,
            .steps,
            .testimonial-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-body {
                grid-template-columns: 95px 1fr;
            }

            .connected {
                display: none;
            }

            .cta,
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }

        @media(max-width: 600px) {

            .nav-actions .login-link {
                display: none;
            }

            .brand {
                font-size: 18px;
            }

            .hero h1 {
                font-size: 42px;
            }

            .hero-description {
                font-size: 14px;
            }

            .dashboard-window {
                transform: none;
            }

            .social-floating.instagram {
                right: 90px;
            }

            .social-floating.linkedin {
                right: 0;
            }

            .social-floating.facebook {
                left: 0;
            }

            .dashboard-body {
                grid-template-columns: 1fr;
            }

            .side-menu {
                display: none;
            }

            .feature-list {
                grid-template-columns: 1fr;
            }

            .post-row {
                grid-template-columns: 40px 1fr 65px;
            }

            .post-date {
                display: none;
            }

            .footer-links {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <!-- =========================
         HEADER
    ========================== -->

    <header>
        <div class="container nav">

            <a href="{{ url('/') }}" class="brand">
                <div class="brand-icon">S</div>
                Social<span>Scheduler</span>
            </a>

            <nav class="nav-links">
                <a href="#home">Home</a>
                <a href="#features">Features</a>
                <a href="#how-it-works">How It Works</a>
                <a href="#platforms">Platforms</a>
            </nav>

            <div class="nav-actions">

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="login-link">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="login-link">
                            Login
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-btn">
                                Get Started →
                            </a>
                        @endif
                    @endauth
                @endif

            </div>
        </div>
    </header>


    <!-- =========================
         HERO
    ========================== -->

    <section class="hero" id="home">

        <div class="container hero-grid">

            <div>

                <div class="hero-badge">
                    ✦ Smarter Social Media Management
                </div>

                <h1>
                    Plan. Create.<br>
                    <span class="gradient-text">
                        Schedule. Publish.
                    </span>
                </h1>

                <p class="hero-description">
                    SocialScheduler helps you create, schedule and publish
                    your content across Facebook, Instagram and LinkedIn —
                    all from one simple dashboard.
                </p>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="primary-btn hero-btn">
                        Get Started Free →
                    </a>
                @elseif (Route::has('login'))
                    <a href="{{ route('login') }}"
                       class="primary-btn hero-btn">
                        Get Started →
                    </a>
                @endif

                <div class="hero-points">

                    <div class="hero-point">
                        <span class="check">✓</span>
                        Easy to Use
                    </div>

                    <div class="hero-point">
                        <span class="check">✓</span>
                        Schedule Posts
                    </div>

                    <div class="hero-point">
                        <span class="check">✓</span>
                        Multiple Platforms
                    </div>

                </div>

            </div>


            <!-- Dashboard Preview -->

            <div class="hero-visual">

                <div class="social-floating facebook">
                    <div class="social-icon facebook-bg"><svg viewBox="0 0 24 24" aria-label="Facebook" role="img">
    <path fill="white" d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.6 1.7-1.6h1.8V3.8c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.5-4 4.1V10H8v3h2.6v8h2.9z"/>
</svg></div>
                </div>

                <div class="social-floating instagram">
                    <div class="social-icon instagram-bg"><svg viewBox="0 0 24 24" aria-label="Instagram" role="img">
    <rect x="4" y="4" width="16" height="16" rx="4" fill="none" stroke="white" stroke-width="2"/>
    <circle cx="12" cy="12" r="3.6" fill="none" stroke="white" stroke-width="2"/>
    <circle cx="17.3" cy="6.8" r="1.2" fill="white"/>
</svg></div>
                </div>

                <div class="social-floating linkedin">
                    <div class="social-icon linkedin-bg"><svg viewBox="0 0 24 24" aria-label="LinkedIn" role="img">
    <text x="3" y="17.5" fill="white" font-size="12.5" font-family="Arial, sans-serif" font-weight="700">in</text>
</svg></div>
                </div>

                <div class="dashboard-window">

                    <div class="dashboard-top">

                        <div class="mini-brand">
                            <div class="mini-logo"></div>
                            SocialScheduler
                        </div>

                        <span style="font-size:13px;color:#8994aa;">
                            ●
                        </span>

                    </div>


                    <div class="dashboard-body">

                        <div class="side-menu">

                            <div class="side-item active">
                                <svg class="mock-icon fill" viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                                    <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                                    <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                                    <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                                </svg>
                                Dashboard
                            </div>

                            <div class="side-item">
                                <svg class="mock-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M4 20h4L19 9l-4-4L4 16v4z"></path>
                                    <path d="M13.5 6.5l4 4"></path>
                                </svg>
                                Create Post
                            </div>

                            <div class="side-item">
                                <svg class="mock-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="8.5"></circle>
                                    <path d="M12 7v5l3 2"></path>
                                </svg>
                                Scheduled Posts
                            </div>

                            <div class="side-item">
                                <svg class="mock-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="8" r="3.2"></circle>
                                    <path d="M5.5 20c.7-3.2 3-5 6.5-5s5.8 1.8 6.5 5"></path>
                                </svg>
                                Accounts
                            </div>

                            <div class="side-item">
                                <svg class="mock-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M4 19V5"></path>
                                    <path d="M4 19h16"></path>
                                    <path d="M7 16l4-5 3 2 5-7"></path>
                                </svg>
                                Analytics
                            </div>

                            <div class="side-item">
                                <svg class="mock-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19 13.5l1.2 1-.2 1.8-1.7.8-1.4 2-1.8-.2-.8-1.6h-2.6l-.8 1.6-1.8.2-1.4-2-1.7-.8-.2-1.8 1.2-1v-3l-1.2-1 .2-1.8 1.7-.8 1.4-2 1.8.2.8 1.6h2.6l.8-1.6 1.8-.2 1.4 2 1.7.8.2 1.8-1.2 1v3z"></path>
                                </svg>
                                Settings
                            </div>

                        </div>


                        <div class="post-area">

                            <div class="post-heading">
                                Create New Post
                            </div>

                            <div class="post-box">
                                What's on your mind?
                            </div>

                            <button class="schedule-btn">
                                Schedule Post
                            </button>

                        </div>


                        <div class="connected">

                            <div class="connected-title">
                                Connected Accounts
                            </div>

                            <div class="account">

                                <div class="account-icon facebook-bg">
                                    <svg viewBox="0 0 24 24" aria-label="Facebook" role="img">
    <path fill="white" d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.6 1.7-1.6h1.8V3.8c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.5-4 4.1V10H8v3h2.6v8h2.9z"/>
</svg>
                                </div>

                                <div>
                                    <div class="account-name">
                                        Facebook
                                    </div>

                                    <div class="connected-status">
                                        Connected
                                    </div>
                                </div>

                            </div>


                            <div class="account">

                                <div class="account-icon instagram-bg">
                                    <svg viewBox="0 0 24 24" aria-label="Instagram" role="img">
    <rect x="4" y="4" width="16" height="16" rx="4" fill="none" stroke="white" stroke-width="2"/>
    <circle cx="12" cy="12" r="3.6" fill="none" stroke="white" stroke-width="2"/>
    <circle cx="17.3" cy="6.8" r="1.2" fill="white"/>
</svg>
                                </div>

                                <div>
                                    <div class="account-name">
                                        Instagram
                                    </div>

                                    <div class="connected-status">
                                        Connected
                                    </div>
                                </div>

                            </div>


                            <div class="account">

                                <div class="account-icon linkedin-bg">
                                    <svg viewBox="0 0 24 24" aria-label="LinkedIn" role="img">
    <text x="3" y="17.5" fill="white" font-size="12.5" font-family="Arial, sans-serif" font-weight="700">in</text>
</svg>
                                </div>

                                <div>
                                    <div class="account-name">
                                        LinkedIn
                                    </div>

                                    <div class="connected-status">
                                        Connected
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         PLATFORMS
    ========================== -->

    <section class="platform-section" id="platforms">

        <div class="container">

            <div class="section-heading">

                <div class="eyebrow">
                    POWERED BY OFFICIAL APIs
                </div>

                <h2>
                    Publish on Facebook, Instagram & LinkedIn
                </h2>

                <p>
                    Connect your social accounts and manage your content
                    from one centralized dashboard.
                </p>

            </div>


            <div class="platform-grid">

                <div class="platform-card">

                    <div class="platform-logo facebook-bg">
                        <svg viewBox="0 0 24 24" aria-label="Facebook" role="img">
    <path fill="white" d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.6 1.7-1.6h1.8V3.8c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.5-4 4.1V10H8v3h2.6v8h2.9z"/>
</svg>
                    </div>

                    <h3>Facebook</h3>

                    <p>
                        Connect your Facebook Page, create content and
                        automatically publish scheduled posts.
                    </p>

                </div>


                <div class="platform-card">

                    <div class="platform-logo instagram-bg">
                        <svg viewBox="0 0 24 24" aria-label="Instagram" role="img">
    <rect x="4" y="4" width="16" height="16" rx="4" fill="none" stroke="white" stroke-width="2"/>
    <circle cx="12" cy="12" r="3.6" fill="none" stroke="white" stroke-width="2"/>
    <circle cx="17.3" cy="6.8" r="1.2" fill="white"/>
</svg>
                    </div>

                    <h3>Instagram</h3>

                    <p>
                        Schedule beautiful Instagram content and
                        publish it automatically at the selected time.
                    </p>

                </div>


                <div class="platform-card">

                    <div class="platform-logo linkedin-bg">
                        <svg viewBox="0 0 24 24" aria-label="LinkedIn" role="img">
    <text x="3" y="17.5" fill="white" font-size="12.5" font-family="Arial, sans-serif" font-weight="700">in</text>
</svg>
                    </div>

                    <h3>LinkedIn</h3>

                    <p>
                        Share professional updates and scheduled content
                        directly through your LinkedIn account.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         HOW IT WORKS
    ========================== -->

    <section class="how-section" id="how-it-works">

        <div class="container">

            <div class="section-heading">

                <div class="eyebrow">
                    HOW IT WORKS
                </div>

                <h2>
                    Get Started in 3 Simple Steps
                </h2>

                <p>
                    Manage your social media content quickly,
                    securely and effortlessly.
                </p>

            </div>


            <div class="steps">

                <div class="step">

                    <div class="step-number">
                        1
                    </div>

                    <h3>
                        Create Your Account
                    </h3>

                    <p>
                        Sign up and create your SocialScheduler
                        account in just a few clicks.
                    </p>

                </div>


                <div class="step">

                    <div class="step-number">
                        2
                    </div>

                    <h3>
                        Connect Your Platforms
                    </h3>

                    <p>
                        Connect Facebook, Instagram and LinkedIn
                        securely with your account.
                    </p>

                </div>


                <div class="step">

                    <div class="step-number">
                        3
                    </div>

                    <h3>
                        Schedule & Publish
                    </h3>

                    <p>
                        Create your post, select a date and time,
                        then let SocialScheduler handle publishing.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         FEATURES
    ========================== -->

    <section class="features-section" id="features">

        <div class="container features-grid">

            <div class="features-content">

                <div class="eyebrow">
                    WHY CHOOSE SOCIALSCHEDULER
                </div>

                <h2>
                    Everything You Need to Manage Your Social Media
                </h2>

                <p>
                    SocialScheduler brings your social publishing workflow
                    together in one place. Create posts, schedule content,
                    connect social accounts and track your publishing activity.
                </p>


                <div class="feature-list">

                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        Schedule Posts
                    </div>

                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        Multiple Platforms
                    </div>

                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        Secure Account Connections
                    </div>

                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        Easy to Use
                    </div>

                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        Automatic Publishing
                    </div>

                    <div class="feature-item">
                        <span class="feature-check">✓</span>
                        Scheduled Post Management
                    </div>

                </div>

            </div>


            <!-- Schedule Preview -->

            <div class="schedule-preview">

                <div class="preview-title">

                    <strong>
                        Scheduled Posts
                    </strong>

                    <span class="preview-filter">
                        All Platforms
                    </span>

                </div>


                <div class="post-row">

                    <div class="post-thumb facebook-thumb" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="white" d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.6 1.7-1.6h1.8V3.8c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.5-4 4.1V10H8v3h2.6v8h2.9z"/>
                            </svg>
                        </div>

                    <div>
                        <div class="post-name">
                            New Product Launch
                        </div>
                        <div class="post-platform">
                            Facebook
                        </div>
                    </div>

                    <div class="post-date">
                        Scheduled
                    </div>

                    <div class="status">
                        Scheduled
                    </div>

                </div>


                <div class="post-row">

                    <div class="post-thumb instagram-thumb" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="4" y="4" width="16" height="16" rx="4" fill="none" stroke="white" stroke-width="2"/>
                                <circle cx="12" cy="12" r="3.6" fill="none" stroke="white" stroke-width="2"/>
                                <circle cx="17.3" cy="6.8" r="1.2" fill="white"/>
                            </svg>
                        </div>

                    <div>
                        <div class="post-name">
                            Behind the Scenes
                        </div>
                        <div class="post-platform">
                            Instagram
                        </div>
                    </div>

                    <div class="post-date">
                        Scheduled
                    </div>

                    <div class="status">
                        Scheduled
                    </div>

                </div>


                <div class="post-row">

                    <div class="post-thumb linkedin-thumb" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <text x="3" y="17.5" fill="white" font-size="12.5" font-family="Arial, sans-serif" font-weight="700">in</text>
                            </svg>
                        </div>

                    <div>
                        <div class="post-name">
                            Business Update
                        </div>
                        <div class="post-platform">
                            LinkedIn
                        </div>
                    </div>

                    <div class="post-date">
                        Scheduled
                    </div>

                    <div class="status">
                        Scheduled
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         TESTIMONIALS
    ========================== -->

    <section class="testimonial-section">

        <div class="container">

            <div class="section-heading">

                <div class="eyebrow">
                    BUILT FOR SOCIAL MEDIA WORKFLOWS
                </div>

                <h2>
                    Simple. Organized. Automated.
                </h2>

                <p>
                    SocialScheduler helps keep your publishing workflow
                    organized and your content scheduled.
                </p>

            </div>


            <div class="testimonial-grid">

                <div class="testimonial">

                    <div class="person">

                        <div class="avatar">
                            S
                        </div>

                        <div>
                            <strong>
                                Social Media Creator
                            </strong>

                            <span>
                                Content Management
                            </span>
                        </div>

                    </div>

                    <p>
                        Create and schedule content from one place
                        instead of managing every platform separately.
                    </p>

                    <div class="stars">
                        ★★★★★
                    </div>

                </div>


                <div class="testimonial">

                    <div class="person">

                        <div class="avatar">
                            B
                        </div>

                        <div>
                            <strong>
                                Business Owner
                            </strong>

                            <span>
                                Social Media Management
                            </span>
                        </div>

                    </div>

                    <p>
                        Scheduled publishing makes it easier to keep
                        social media content consistent.
                    </p>

                    <div class="stars">
                        ★★★★★
                    </div>

                </div>


                <div class="testimonial">

                    <div class="person">

                        <div class="avatar">
                            M
                        </div>

                        <div>
                            <strong>
                                Marketing Manager
                            </strong>

                            <span>
                                Digital Marketing
                            </span>
                        </div>

                    </div>

                    <p>
                        Manage connected accounts, scheduled posts and
                        publishing activity through one dashboard.
                    </p>

                    <div class="stars">
                        ★★★★★
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================
         CTA
    ========================== -->

    <section class="cta-section">

        <div class="container">

            <div class="cta">

                <div>

                    <div class="cta-label">
                        READY TO GET STARTED?
                    </div>

                    <h2>
                        Make Your Social Media Work Easier
                    </h2>

                    <p>
                        Create, schedule and publish your content
                        from one simple place.
                    </p>

                </div>


                @if (Route::has('register'))

                    <a href="{{ route('register') }}"
                       class="primary-btn hero-btn">
                        Get Started Free →
                    </a>

                @elseif (Route::has('login'))

                    <a href="{{ route('login') }}"
                       class="primary-btn hero-btn">
                        Get Started →
                    </a>

                @endif

            </div>

        </div>

    </section>


    <!-- =========================
         FOOTER
    ========================== -->

    <footer>

        <div class="container footer-content">

            <a href="{{ url('/') }}" class="brand">
                <div class="brand-icon">S</div>
                Social<span>Scheduler</span>
            </a>


            <div class="footer-links">

                <a href="#home">
                    Home
                </a>

                <a href="#features">
                    Features
                </a>

                <a href="#how-it-works">
                    How It Works
                </a>

                <a href="#platforms">
                    Platforms
                </a>

            </div>


            <div class="copyright">
                © {{ date('Y') }} SocialScheduler. All rights reserved.
            </div>

        </div>

    </footer>

</body>
</html>