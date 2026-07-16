<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать!</title>
    <style>
        /* Сброс для почтовых клиентов */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
            background-color: #f4f7fb;
            line-height: 1.6;
            color: #2d3748;
        }

        .container {
            max-width: 580px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 48px 40px 40px;
            text-align: center;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f093fb, #f5576c, #4facfe, #43e97b);
            background-size: 300% 100%;
            animation: gradientMove 4s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .logo {
            font-size: 48px;
            margin-bottom: 12px;
            display: block;
        }

        .header h1 {
            color: #ffffff;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 18px;
            margin-top: 8px;
            font-weight: 300;
        }

        .content {
            padding: 48px 40px 40px;
        }

        .greeting {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 12px;
        }

        .greeting span {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .message {
            font-size: 16px;
            color: #4a5568;
            margin: 20px 0 28px;
            line-height: 1.8;
        }

        .message strong {
            color: #2d3748;
            font-weight: 600;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin: 30px 0;
        }

        .feature-item {
            background: #f7fafc;
            padding: 18px 16px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #edf2f7;
            transition: all 0.2s;
        }

        .feature-item .icon {
            font-size: 28px;
            display: block;
            margin-bottom: 6px;
        }

        .feature-item .label {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
        }

        .feature-item .desc {
            font-size: 12px;
            color: #718096;
            margin-top: 2px;
        }

        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            padding: 16px 48px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            margin: 12px 0 8px;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.35);
            transition: all 0.3s;
            text-align: center;
            letter-spacing: 0.3px;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.45);
        }

        .button-secondary {
            display: inline-block;
            color: #667eea !important;
            text-decoration: none;
            font-weight: 500;
            margin: 8px 0 0;
            border-bottom: 2px solid transparent;
            transition: border-color 0.2s;
        }

        .button-secondary:hover {
            border-bottom-color: #667eea;
        }

        .divider {
            border: none;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 32px 0;
        }

        .footer {
            background: #f7fafc;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #edf2f7;
        }

        .footer p {
            font-size: 13px;
            color: #a0aec0;
            margin: 4px 0;
            line-height: 1.6;
        }

        .footer a {
            color: #667eea !important;
            text-decoration: none;
        }

        .footer .social-links {
            margin-top: 12px;
        }

        .footer .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #a0aec0 !important;
            font-size: 20px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer .social-links a:hover {
            color: #667eea !important;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px 16px;
                border-radius: 16px;
            }

            .header {
                padding: 32px 24px 28px;
            }

            .header h1 {
                font-size: 26px;
            }

            .content {
                padding: 32px 24px 28px;
            }

            .greeting {
                font-size: 24px;
            }

            .feature-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .button {
                padding: 14px 32px;
                font-size: 15px;
                width: 100%;
                text-align: center;
            }

            .footer {
                padding: 24px 20px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Хедер -->
    <div class="header">
        <span class="logo">🚀</span>
        <h1>Добро пожаловать!</h1>
        <p>Мы рады видеть вас в нашем сообществе</p>
    </div>

    <!-- Основной контент -->
    <div class="content">
        <div class="greeting">
            Привет, <span>{{ $user->name ?? 'друг' }}</span>! 👋
        </div>

        <div class="message">
            <strong>Спасибо, что присоединились к нам!</strong><br>
            Мы создали это пространство, чтобы помочь вам достигать целей,
            вдохновляться и находить единомышленников.
            Ваш аккаунт успешно активирован, и мы готовы начать этот путь вместе.
        </div>

        <!-- Функции/преимущества -->
        <div class="feature-grid">
            <div class="feature-item">
                <span class="icon">✨</span>
                <div class="label">Персональный подход</div>
                <div class="desc">Контент под ваш запрос</div>
            </div>
            <div class="feature-item">
                <span class="icon">🤝</span>
                <div class="label">Сообщество</div>
                <div class="desc">Общайтесь с единомышленниками</div>
            </div>
            <div class="feature-item">
                <span class="icon">📚</span>
                <div class="label">Обучение</div>
                <div class="desc">Доступ к материалам 24/7</div>
            </div>
            <div class="feature-item">
                <span class="icon">🎯</span>
                <div class="label">Прогресс</div>
                <div class="desc">Отслеживайте свои успехи</div>
            </div>
        </div>

        <!-- Кнопка действия -->
        <div style="text-align: center; margin: 28px 0 12px;">
            <a href="{{ url('/dashboard') }}" class="button">
                Перейти в личный кабинет →
            </a>
            <br>
            <a href="{{ url('/help') }}" class="button-secondary">
                💡 Нужна помощь?
            </a>
        </div>

        <hr class="divider">

        <!-- Дополнительная информация -->
        <div style="font-size: 14px; color: #718096; text-align: center;">
            <p style="margin-bottom: 4px;">
                <strong>Ваши данные для входа:</strong>
            </p>
            <p style="font-size: 13px; background: #f7fafc; padding: 10px; border-radius: 8px; display: inline-block; margin: 4px 0;">
                📧 <span style="font-weight: 600;">{{ $user->email ?? 'email@example.com' }}</span>
            </p>
            <p style="font-size: 13px; margin-top: 8px; color: #a0aec0;">
                Пароль вы установили при регистрации.
                <a href="{{ url('/password/reset') }}" style="color: #667eea; text-decoration: none; border-bottom: 1px dashed #667eea;">
                    Забыли пароль?
                </a>
            </p>
        </div>
    </div>

    <!-- Футер -->
    <div class="footer">
        <p style="font-weight: 500; color: #4a5568;">
            С уважением, команда {{ config('app.name') }}
        </p>
        <p>
            © {{ date('Y') }} {{ config('app.name') }}. Все права защищены.
        </p>
        <p style="font-size: 12px; color: #cbd5e0; margin-top: 8px;">
            Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него.
            <br>
            <a href="{{ url('/unsubscribe') }}" style="color: #a0aec0; text-decoration: underline;">Отписаться</a>
        </p>
    </div>
</div>
</body>
</html>
