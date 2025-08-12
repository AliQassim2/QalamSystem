<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Welcome Back</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 420px;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #718096;
            font-size: 16px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
            animation: slideIn 0.3s ease-out;
        }

        .alert-error {
            background: #fed7d7;
            color: #c53030;
            border: 1px solid #feb2b2;
        }

        .alert-success {
            background: #c6f6d5;
            color: #2f855a;
            border: 1px solid #9ae6b4;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-input:hover {
            border-color: #cbd5e0;
        }

        .form-error {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .send-code-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            transition: all 0.2s ease;
        }

        .send-code-link:hover {
            color: #5a67d8;
            transform: translateX(4px);
        }

        .toggle-section {
            text-align: center;
            margin: 24px 0;
        }

        .toggle-btn {
            background: linear-gradient(135deg, #718096, #4a5568);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .toggle-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .fade-transition {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .fade-transition.show {
            opacity: 1;
            transform: translateY(0);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .input-icon:hover {
            color: #667eea;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .loading {
            animation: pulse 1s infinite;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 24px;
                margin: 10px;
            }

            .login-title {
                font-size: 24px;
            }

            .form-input {
                padding: 14px 16px;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Please sign in to your account</p>
        </div>

        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf

            <div class="form-group">
                <label for="login" class="form-label">Email / Username / Phone</label>
                <input type="text"
                    name="login"
                    id="login"
                    class="form-input"
                    value="{{ old('login') }}"
                    required
                    placeholder="Enter your email, username, or phone">
                @error('login')
                <div class="form-error">
                    <span>⚠</span> {{ $message }}
                </div>
                @enderror
            </div>

            <div id="passwordField" class="form-group fade-transition show">
                <label for="password" class="form-label">Password</label>
                <div style="position: relative;">
                    <input type="password"
                        name="password"
                        id="password"
                        class="form-input"
                        placeholder="Enter your password">
                    <span class="input-icon" id="togglePassword">👁</span>
                </div>
                @error('password')
                <div class="form-error">
                    <span>⚠</span> {{ $message }}
                </div>
                @enderror
            </div>

            <div id="codeField" class="form-group fade-transition" style="display: none;">
                <label for="code" class="form-label">Login Code</label>
                <input type="text"
                    name="code"
                    id="code"
                    class="form-input"
                    placeholder="Enter the 6-digit code">
                <a href="{{ route('send.login.code') }}" id="sendCodeLink" class="send-code-link">
                    📧 Send code to email
                </a>
                @error('code')
                <div class="form-error">
                    <span>⚠</span> {{ $message }}
                </div>
                @enderror
            </div>

            <div class="toggle-section">
                <button type="button" id="toggleMethod" class="toggle-btn">
                    🔐 Use Code Instead
                </button>
            </div>

            <button type="submit" class="login-btn" id="loginButton">
                Sign In
            </button>
        </form>
    </div>

    <script>
        // DOM elements
        const passwordField = document.getElementById('passwordField');
        const codeField = document.getElementById('codeField');
        const toggleBtn = document.getElementById('toggleMethod');
        const sendCodeLink = document.getElementById('sendCodeLink');
        const loginInput = document.getElementById('login');
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');

        let useCode = false;

        // Password visibility toggle
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁' : '🙈';
        });

        // Login method toggle
        toggleBtn.addEventListener('click', function() {
            useCode = !useCode;

            // Add fade out effect
            const currentField = useCode ? passwordField : codeField;
            const nextField = useCode ? codeField : passwordField;

            currentField.classList.remove('show');

            setTimeout(() => {
                currentField.style.display = 'none';
                nextField.style.display = 'block';

                setTimeout(() => {
                    nextField.classList.add('show');
                }, 50);
            }, 150);

            // Update button text and icon
            if (useCode) {
                toggleBtn.innerHTML = '🔑 Use Password Instead';
                toggleBtn.style.background = 'linear-gradient(135deg, #48bb78, #38a169)';
            } else {
                toggleBtn.innerHTML = '🔐 Use Code Instead';
                toggleBtn.style.background = 'linear-gradient(135deg, #718096, #4a5568)';
            }
        });

        // Send code functionality
        sendCodeLink.addEventListener('click', function(e) {
            e.preventDefault();
            const loginValue = loginInput.value.trim();

            if (!loginValue) {
                showNotification('Please enter your email, username, or phone first.', 'error');
                loginInput.focus();
                return;
            }

            // Show loading state
            this.innerHTML = '⏳ Sending...';
            this.style.pointerEvents = 'none';

            // Simulate API call (replace with actual endpoint)
            setTimeout(() => {
                this.innerHTML = '✅ Code Sent!';
                showNotification('Login code sent successfully!', 'success');

                setTimeout(() => {
                    this.innerHTML = '📧 Resend Code';
                    this.style.pointerEvents = 'auto';
                }, 2000);
            }, 1500);

            // In real implementation:
            window.location.href = `{{ route('send.login.code') }}?login=${encodeURIComponent(loginValue)}`;
        });

        // Form submission with loading state
        loginForm.addEventListener('submit', function(e) {
            loginButton.innerHTML = '⏳ Signing In...';
            loginButton.classList.add('loading');
            loginButton.disabled = true;
        });

        // Input animations
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Notification system
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type}`;
            notification.textContent = message;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '1000';
            notification.style.minWidth = '300px';

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Auto-focus first input
        window.addEventListener('load', () => {
            loginInput.focus();
        });
    </script>
</body>

</html>