<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Регистрация</title>

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
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
            background: #4facfe;
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        body::after {
            width: 400px;
            height: 400px;
            background: #43e97b;
            bottom: -150px;
            right: -150px;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-30px, 30px) scale(1.1); }
            66% { transform: translate(20px, -20px) scale(0.9); }
        }

        .register-container {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }

        .register-card {
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

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-header .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            border-radius: 20px;
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            box-shadow: 0 12px 40px rgba(245, 87, 108, 0.3);
            transition: transform 0.3s ease;
        }

        .register-header .logo:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .register-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a202c;
            letter-spacing: -0.5px;
        }

        .register-header p {
            color: #718096;
            font-size: 15px;
            margin-top: 8px;
            font-weight: 400;
        }

        .register-header .brand {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
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
            border-color: #f093fb;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(240, 147, 251, 0.1);
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

        /* Специфичные для регистрации стили для поля имени */
        .form-control.name-input {
            background-image: linear-gradient(135deg, #f093fb08, #f5576c08);
        }

        .error-message {
            margin-top: 6px;
            font-size: 13px;
            color: #fc8181;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            75% { transform: translateX(6px); }
        }

        .error-message::before {
            content: '⚠️';
            font-size: 14px;
        }

        /* Password strength indicator */
        .password-strength {
            margin-top: 8px;
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .strength-bar {
            flex: 1;
            height: 4px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            gap: 4px;
        }

        .strength-bar .segment {
            flex: 1;
            height: 100%;
            background: #e2e8f0;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .strength-bar .segment.active.weak { background: #fc8181; }
        .strength-bar .segment.active.medium { background: #f6ad55; }
        .strength-bar .segment.active.strong { background: #68d391; }
        .strength-bar .segment.active.very-strong { background: #4fd1c5; }

        .strength-text {
            font-size: 12px;
            color: #a0aec0;
            font-weight: 500;
            min-width: 60px;
            text-align: right;
        }

        .strength-text.weak { color: #fc8181; }
        .strength-text.medium { color: #f6ad55; }
        .strength-text.strong { color: #68d391; }
        .strength-text.very-strong { color: #4fd1c5; }

        .password-requirements {
            margin-top: 8px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 16px;
        }

        .requirement {
            font-size: 12px;
            color: #a0aec0;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s;
        }

        .requirement.met {
            color: #68d391;
        }

        .requirement .check {
            display: inline-block;
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
            background: linear-gradient(135deg, #f093fb, #f5576c);
            border-color: #f093fb;
        }

        .checkbox-wrapper input:checked + .checkbox-custom::after {
            content: '✓';
            color: white;
            font-size: 14px;
            font-weight: 700;
        }

        .checkbox-wrapper:hover .checkbox-custom {
            border-color: #f093fb;
        }

        .btn-register {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            color: white;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(245, 87, 108, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(245, 87, 108, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .btn-register::after {
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

        .btn-register:active::after {
            width: 300px;
            height: 300px;
        }

        .btn-register .spinner {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto;
        }

        .btn-register.loading .btn-text {
            display: none;
        }

        .btn-register.loading .spinner {
            display: block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            font-size: 15px;
            color: #718096;
        }

        .login-link a {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .login-link a:hover {
            opacity: 0.7;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .register-card {
                padding: 32px 24px 28px;
            }

            .register-header h1 {
                font-size: 24px;
            }

            .register-header .logo {
                width: 60px;
                height: 60px;
                font-size: 26px;
            }

            .password-requirements {
                grid-template-columns: 1fr;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
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

            .register-card {
                background: rgba(26, 32, 44, 0.95);
                box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            }

            .register-header h1 {
                color: #f7fafc;
            }

            .register-header p {
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
                border-color: #f093fb;
                box-shadow: 0 0 0 4px rgba(240, 147, 251, 0.1);
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

            .login-link {
                color: #a0aec0;
            }

            .strength-bar {
                background: #2d3748;
            }

            .strength-bar .segment {
                background: #2d3748;
            }

            .requirement {
                color: #718096;
            }

            .requirement.met {
                color: #68d391;
            }
        }
    </style>
</head>
<body>
<div class="register-container">
    <div class="register-card">
        <!-- Header -->
        <div class="register-header">
            <div class="logo">✨</div>
            <h1>Создайте аккаунт</h1>
            <p>
                Присоединяйтесь к
                <span class="brand">{{ config('app.name') }}</span>
            </p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">
                    Имя <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <span class="input-icon">👤</span>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="form-control name-input @error('name') error @enderror"
                        placeholder="Иван Иванов"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                    >
                </div>
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

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
                        placeholder="Минимум 8 символов"
                        required
                        autocomplete="new-password"
                        minlength="8"
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

                <!-- Password Strength Indicator -->
                <div class="password-strength" id="strengthIndicator">
                    <div class="strength-bar">
                        <div class="segment" id="seg1"></div>
                        <div class="segment" id="seg2"></div>
                        <div class="segment" id="seg3"></div>
                        <div class="segment" id="seg4"></div>
                    </div>
                    <span class="strength-text" id="strengthText">Слабый</span>
                </div>

                <!-- Password Requirements -->
                <div class="password-requirements" id="passwordRequirements">
                        <span class="requirement" id="reqLength">
                            <span class="check">◯</span> Минимум 8 символов
                        </span>
                    <span class="requirement" id="reqUpper">
                            <span class="check">◯</span> Заглавная буква
                        </span>
                    <span class="requirement" id="reqLower">
                            <span class="check">◯</span> Строчная буква
                        </span>
                    <span class="requirement" id="reqNumber">
                            <span class="check">◯</span> Цифра
                        </span>
                </div>

                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">
                    Подтвердите пароль <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <span class="input-icon">✅</span>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="form-control password-input @error('password_confirmation') error @enderror"
                        placeholder="Повторите пароль"
                        required
                        autocomplete="new-password"
                    >
                    <button
                        type="button"
                        class="input-icon password-icon"
                        id="toggleConfirmPassword"
                        aria-label="Показать/скрыть пароль"
                    >
                        👁️
                    </button>
                </div>
                @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Terms -->
            <div class="form-options">
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="terms" id="terms" required>
                    <span class="checkbox-custom"></span>
                    Я согласен с
{{--                    <a href="{{ route('terms') }}" target="_blank" style="color: #f5576c; text-decoration: none; font-weight: 500;">--}}
                    <a href="#" target="_blank" style="color: #f5576c; text-decoration: none; font-weight: 500;">
                        условиями
                    </a>
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-register" id="registerBtn">
                <span class="btn-text">Создать аккаунт →</span>
                <span class="spinner"></span>
            </button>

            <!-- Login Link -->
            <div class="login-link">
                Уже есть аккаунт?
                <a href="{{ route('login') }}">Войти</a>
            </div>
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

    document.getElementById('toggleConfirmPassword')?.addEventListener('click', function() {
        const passwordInput = document.getElementById('password_confirmation');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
    });

    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthSegments = [
        document.getElementById('seg1'),
        document.getElementById('seg2'),
        document.getElementById('seg3'),
        document.getElementById('seg4')
    ];
    const strengthText = document.getElementById('strengthText');

    // Requirements
    const reqLength = document.getElementById('reqLength');
    const reqUpper = document.getElementById('reqUpper');
    const reqLower = document.getElementById('reqLower');
    const reqNumber = document.getElementById('reqNumber');

    function checkPasswordStrength(password) {
        let score = 0;

        // Length check
        if (password.length >= 8) {
            score++;
            reqLength.querySelector('.check').textContent = '✅';
            reqLength.classList.add('met');
        } else {
            reqLength.querySelector('.check').textContent = '◯';
            reqLength.classList.remove('met');
        }

        // Uppercase
        if (/[A-Z]/.test(password)) {
            score++;
            reqUpper.querySelector('.check').textContent = '✅';
            reqUpper.classList.add('met');
        } else {
            reqUpper.querySelector('.check').textContent = '◯';
            reqUpper.classList.remove('met');
        }

        // Lowercase
        if (/[a-z]/.test(password)) {
            score++;
            reqLower.querySelector('.check').textContent = '✅';
            reqLower.classList.add('met');
        } else {
            reqLower.querySelector('.check').textContent = '◯';
            reqLower.classList.remove('met');
        }

        // Number
        if (/[0-9]/.test(password)) {
            score++;
            reqNumber.querySelector('.check').textContent = '✅';
            reqNumber.classList.add('met');
        } else {
            reqNumber.querySelector('.check').textContent = '◯';
            reqNumber.classList.remove('met');
        }

        // Update strength indicator
        const levels = ['Слабый', 'Средний', 'Сильный', 'Очень сильный'];
        const classes = ['weak', 'medium', 'strong', 'very-strong'];

        // Reset all segments
        strengthSegments.forEach(seg => {
            seg.className = 'segment';
        });

        // Activate segments based on score
        const activeSegments = Math.min(score, 4);
        for (let i = 0; i < activeSegments; i++) {
            strengthSegments[i].classList.add('active', classes[score - 1] || 'weak');
        }

        if (password.length === 0) {
            strengthText.textContent = '';
            strengthText.className = 'strength-text';
        } else {
            strengthText.textContent = levels[score - 1] || 'Слабый';
            strengthText.className = `strength-text ${classes[score - 1] || 'weak'}`;
        }
    }

    passwordInput?.addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });

    // Loading state on submit
    document.getElementById('registerForm')?.addEventListener('submit', function(e) {
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
            e.preventDefault();
            termsCheckbox.focus();
            termsCheckbox.style.outline = '2px solid #fc8181';
            setTimeout(() => {
                termsCheckbox.style.outline = 'none';
            }, 2000);
            return;
        }

        const btn = document.getElementById('registerBtn');
        btn.classList.add('loading');
        btn.disabled = true;
    });

    // Password match validation (real-time)
    const confirmPassword = document.getElementById('password_confirmation');
    confirmPassword?.addEventListener('input', function() {
        const password = document.getElementById('password').value;
        if (this.value.length > 0 && this.value !== password) {
            this.classList.add('error');
            this.style.borderColor = '#fc8181';
        } else {
            this.classList.remove('error');
            this.style.borderColor = '';
        }
    });
</script>
</body>
</html>
