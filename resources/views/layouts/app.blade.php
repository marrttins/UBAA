<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIBEN Alumni Portal | Lagos Branch</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/uniben-logo.png') }}">

    <style>
        :root {
            --primary: #4A0E4E;
            --primary-dark: #370a3a;
            --secondary: #D4AF37;
            --bg-body: #f8f9fa;
            --text-dark: #1e1e1e;
            --text-gray: #6b7280;
            --input-bg: #f3f4f6;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            min-height: 100vh;
            color: var(--text-dark);
            display: flex;
        }

        .auth-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Split Screen Left Side (Desktop Only) */
        .auth-visual {
            display: none;
            width: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 60px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-visual::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
            top: -100px;
            right: -100px;
        }

        .visual-content {
            z-index: 1;
        }

        .visual-logo {
            width: 120px;
            height: 120px;
            background: white;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 32px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .visual-title {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .visual-subtitle {
            font-size: 16px;
            opacity: 0.8;
            max-width: 400px;
            line-height: 1.6;
        }

        /* Right Side (Form) */
        .auth-content {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background-image: radial-gradient(#d1d5db 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 450px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 48px 40px;
            border: 1px solid rgba(0,0,0,0.02);
        }

        /* Branding for Mobile */
        .mobile-branding {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 32px;
        }

        .logo-img {
            width: 60px;
            height: 60px;
            background: #000;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 12px;
        }

        .app-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        p.subtitle {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 32px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i:not(.toggle-pw) {
            position: absolute;
            left: 16px;
            color: #9ca3af;
            font-size: 14px;
        }

        .toggle-pw {
            position: absolute;
            right: 16px;
            cursor: pointer;
            color: #9ca3af;
            font-size: 14px;
        }

        .name-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        @media (min-width: 576px) {
            .name-grid {
                grid-template-columns: 1fr 1fr 1fr;
            }
        }

        input:not([type="checkbox"]), select {
            width: 100%;
            padding: 16px 16px 16px 48px;
            background: var(--input-bg);
            border: 1px solid transparent;
            border-radius: 12px;
            font-size: 14px;
            color: var(--text-dark);
            transition: 0.2s;
            outline: none;
        }

        input:focus, select:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(74, 14, 78, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        .checkbox-group input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .checkbox-group label {
            text-transform: none;
            letter-spacing: 0;
            font-weight: 500;
            color: var(--text-gray);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .auth-alt {
            margin-top: 32px;
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #f1f5f9;
        }

        .alt-text {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 16px;
        }

        .btn-alt {
            width: 100%;
            padding: 14px;
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-alt:hover {
            background: var(--primary);
            color: white;
        }

        @media (min-width: 992px) {
            .auth-visual { display: flex; }
            .auth-content { width: 50%; }
            .mobile-branding { display: none; }
            .auth-card { box-shadow: none; border: none; padding: 0; max-width: 400px; }
        }

        .error-text { color: #ef4444; font-size: 12px; margin-top: 6px; }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <!-- Visual Side -->
    <div class="auth-visual">
        <div class="visual-content">
            <img src="{{ asset('images/uniben-logo.png') }}" alt="Logo" class="visual-logo">
            <h2 class="visual-title">Great Benin Alumni</h2>
            <p class="visual-subtitle">Welcome to the Lagos Branch digital gateway. Step back into the excellence and connect with your heritage.</p>
            <div style="margin-top: 48px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 24px; font-size: 14px; font-weight: 600;">
                <i class="fa-solid fa-star" style="color: var(--secondary);"></i> UBAA Lagos Branch
            </div>
        </div>
    </div>

    <!-- Form Side -->
    <div class="auth-content">
        @yield('content')
    </div>
</div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById('icon-' + inputId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>
