<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Вход</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Анимированные фоновые круги */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }

        body::before {
            width: 500px;
            height: 500px;
            background: #f093fb;
            top: -200px;
            right: -200px;
            animation-delay: 0s;
        }

        body::after {
            width: 400px;
            height: 400px;
            background: #4facfe;
            bottom: -150px;
            left: -150px;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px 40px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2),
            0 0 0 1px rgba(255, 255, 255, 0.1);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .login-header .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 20px;
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s ease;
        }

        .login-header .logo:hover {
            transform: scale(1.05) rotate(-2deg);
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a202c;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: #718096;
            font-size: 15px;
            margin-top: 8px;
            font-weight: 400;
        }

        .login-header .brand {
            color: #667eea;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }

        .form-group label .required {
            color: #fc8181;
            margin-left: 2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 18px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrapper .input-icon.password-icon {
            left: auto;
            right: 14px;
            cursor: pointer;
            pointer-events: auto;
            font-size: 20px;
            color: #a0aec0;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 4px;
        }

        .input-wrapper .input-icon.password-icon:hover {
            color: #4a5568;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 46px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            color: #2d3748;
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.25s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-control::placeholder {
            color: #a0aec0;
            font-size: 14px;
        }

        .form-control.password-input {
            padding-right: 46px;
        }

        .form-control.error {
            border-color: #fc8181;
            background: #fff5f5;
        }

        .form-control.error:focus {
            box-shadow: 0 0 0 4px rgba(252, 129, 129, 0.1);
        }

        .error-message {
            margin-top: 6px;
            font-size: 13px;
            color: #fc8181;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .error-message::before {
            content: '⚠️';
            font-size: 14px;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 24px 0 28px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 14px;
            color: #4a5568;
            user-select: none;
        }

        .checkbox-wrapper input[type="checkbox"] {
            display: none;
        }

        .checkbox-custom {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e0;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
            background: white;
        }

        .checkbox-wrapper input:checked + .checkbox-custom {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-color: #667eea;
        }

        .checkbox-wrapper input:checked + .checkbox-custom::after {
            content: '✓';
            color: white;
            font-size: 14px;
            font-weight: 700;
        }

        .checkbox-wrapper:hover .checkbox-custom {
            border-color: #667eea;
        }

        .forgot-link {
            font-size: 14px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-login:active::after {
            width: 300px;
            height: 300px;
        }

        .btn-login .spinner {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto;
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        .btn-login.loading .spinner {
            display: block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .register-link {
            text-align: center;
            margin-top: 24px;
            font-size: 15px;
            color: #718096;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .register-link a:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        .session-status {
            padding: 12px 16px;
            background: #c6f6d5;
            border: 1px solid #9ae6b4;
            border-radius: 10px;
            color: #22543d;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .session-status::before {
            content: '✅';
            font-size: 16px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px 28px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .login-header .logo {
                width: 60px;
                height: 60px;
                font-size: 26px;
            }
        }

        /* Тёмная тема */
        @media (prefers-color-scheme: dark) {
            body {
                background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            }

            body::before {
                background: #553c9a;
            }

            body::after {
                background: #2b6cb0;
            }

            .login-card {
                background: rgba(26, 32, 44, 0.95);
                box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            }

            .login-header h1 {
                color: #f7fafc;
            }

            .login-header p {
                color: #a0aec0;
            }

            .form-group label {
                color: #e2e8f0;
            }

            .form-control {
                background: #2d3748;
                border-color: #4a5568;
                color: #f7fafc;
            }

            .form-control:focus {
                background: #2d3748;
                border-color: #667eea;
            }

            .form-control::placeholder {
                color: #718096;
            }

            .checkbox-wrapper {
                color: #e2e8f0;
            }

            .checkbox-custom {
                background: #2d3748;
                border-color: #4a5568;
            }

            .register-link {
                color: #a0aec0;
            }

            .session-status {
                background: #22543d;
                border-color: #2f855a;
                color: #c6f6d5;
            }
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="logo">🚀</div>
            <h1>Добро пожаловать!</h1>
            <p>
                Войдите в свой аккаунт
                <span class="brand">{{ config('app.name') }}</span>
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="session-status">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">
                    Email <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <span class="input-icon">✉️</span>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control @error('email') error @enderror"
                        placeholder="your@email.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">
                    Пароль <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control password-input @error('password') error @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <button
                        type="button"
                        class="input-icon password-icon"
                        id="togglePassword"
                        aria-label="Показать/скрыть пароль"
                    >
                        👁️
                    </button>
                </div>
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Options -->
            <div class="form-options">
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="remember" id="remember_me">
                    <span class="checkbox-custom"></span>
                    Запомнить меня
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Забыли пароль?
                    </a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-login" id="loginBtn">
                <span class="btn-text">Войти в аккаунт →</span>
                <span class="spinner"></span>
            </button>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="register-link">
                    Ещё нет аккаунта?
                    <a href="{{ route('register') }}">Зарегистрироваться</a>
                </div>
            @endif
        </form>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword')?.addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
    });

    // Loading state on submit
    document.getElementById('loginForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('loginBtn');
        btn.classList.add('loading');
        btn.disabled = true;
    });

    // Enter key support для улучшения UX
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const form = document.getElementById('loginForm');
            if (form && document.activeElement?.closest('form') === form) {
                form.dispatchEvent(new Event('submit'));
            }
        }
    });
</script>
</body>
</html>
